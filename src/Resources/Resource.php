<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Constants\ErrorTypes;
use Nextmail\Exception\ApiException;
use Nextmail\Exception\InvalidArgumentException;
use Nextmail\Internal\Defaults;
use Nextmail\Internal\Endpoint;
use Nextmail\Internal\ImageCrop;
use Nextmail\Internal\Messages;
use Nextmail\Internal\Pagination;
use Nextmail\Internal\Protocol;
use Nextmail\Internal\RawBody;
use Nextmail\Internal\RequestPath;
use Nextmail\Internal\Wire;
use Nextmail\Result\Page;
use Nextmail\Transport;

abstract class Resource
{
    protected const CURSOR = Protocol::CURSOR_STYLES['CURSOR'];

    protected const PAGE_TOKEN = Protocol::CURSOR_STYLES['PAGE_TOKEN'];

    public function __construct(protected readonly Transport $transport) {}

    public function __debugInfo(): array
    {
        return [];
    }

    protected function call(
        string $path,
        string $method = 'GET',
        ?array $query = null,
        #[\SensitiveParameter]
        ?array $body = null,
        #[\SensitiveParameter]
        mixed $raw = null,
        ?string $contentType = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
        #[\SensitiveParameter]
        ?string $inboxToken = null,
        bool $anonymous = false,
        bool $idempotent = false,
        ?string $idempotencyKey = null,
        ?bool $repeatable = null,
        int|float|null $timeout = null,
    ): array {
        $result = $this->transport->request(
            $path,
            method: $method,
            query: $query,
            body: $body,
            raw: $raw,
            contentType: $contentType,
            apiKey: $apiKey,
            inboxToken: $inboxToken,
            anonymous: $anonymous,
            idempotent: $idempotent,
            idempotencyKey: $idempotencyKey,
            repeatable: $repeatable,
            timeout: $timeout,
        );

        if (\is_array($result)) {
            return $result;
        }

        if ($result === null) {
            return [];
        }

        throw ApiException::create(
            Messages::NOT_JSON_OBJECT,
            null,
            ErrorTypes::API_ERROR,
            Protocol::ERROR_CODES['UNRECOGNISED_RESPONSE'],
            body: $result,
        );
    }

    protected function text(string $path, string $accept, #[\SensitiveParameter] ?string $apiKey = null): string
    {
        $result = $this->transport->request($path, accept: $accept, apiKey: $apiKey);

        return \is_string($result) ? $result : '';
    }

    protected function bytes(string $path, #[\SensitiveParameter] ?string $apiKey = null): string
    {
        $result = $this->transport->request($path, binary: true, apiKey: $apiKey);

        return \is_string($result) ? $result : '';
    }

    protected function fill(string $pattern, mixed ...$params): string
    {
        return RequestPath::fill($pattern, $params);
    }

    protected function query(mixed ...$values): array
    {
        $query = [];

        foreach ($values as $name => $value) {
            $query[self::queryKey((string) $name)] = $value;
        }

        return $query;
    }

    protected function joined(mixed $values): mixed
    {
        return \is_array($values) ? implode(Protocol::LIST_SEPARATOR, array_map(Endpoint::queryText(...), array_values($values))) : $values;
    }

    protected function flag(?bool $value): ?string
    {
        return $value === null ? null : ($value ? 'true' : 'false');
    }

    protected function instant(mixed $value): mixed
    {
        return Wire::instant($value);
    }

    protected function payload(?array $body): array
    {
        return Wire::body($body);
    }

    protected function windowQuery(string|\DateTimeInterface|null $since, string|\DateTimeInterface|null $until): array
    {
        return $this->query(since: $this->instant($since), until: $this->instant($until));
    }

    protected function cropQuery(?array $crop): array
    {
        return $this->query(crop: ImageCrop::text($crop));
    }

    protected function requestQuery(
        string|\DateTimeInterface|null $since,
        string|\DateTimeInterface|null $until,
        ?bool $failedOnly,
        string|array|null $statuses,
        ?string $path,
    ): array {
        return [...$this->windowQuery($since, $until), ...$this->query(failedOnly: $this->flag($failedOnly), status: $this->joined($statuses), path: $path)];
    }

    protected function fetchPage(
        string $path,
        ?array $query = null,
        array $style = self::CURSOR,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return Pagination::fetchPage($this->transport, $path, $query, $style, $limit, $cursor, $apiKey);
    }

    protected function iteratePages(
        string $path,
        ?array $query = null,
        array $style = self::CURSOR,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return Pagination::walk(
            fn(?string $current): Page => $this->fetchPage($path, $query, $style, $limit, $current, $apiKey),
            $cursor,
        );
    }

    protected function collectAll(
        string $path,
        ?array $query = null,
        array $style = self::CURSOR,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return iterator_to_array($this->iteratePages($path, $query, $style, $limit, $cursor, $apiKey), false);
    }

    protected function fetchList(string $path, ?array $query = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return Pagination::fetchList($this->transport, $path, $query, $apiKey);
    }

    protected function rawContentType(mixed $data, ?string $contentType): ?string
    {
        return RawBody::contentType($data, $contentType);
    }

    protected function uploadTimeout(): float
    {
        return $this->atLeast((float) Defaults::UPLOAD_TIMEOUT);
    }

    protected function turnTimeout(): float
    {
        return $this->atLeast((float) Defaults::CHAT_TURN_TIMEOUT);
    }

    protected static function uploadName(mixed $data, ?string $filename): string
    {
        $name = trim($filename ?? RawBody::fileName($data) ?? '');

        if ($name === '') {
            throw new InvalidArgumentException(Messages::FILENAME_REQUIRED);
        }

        return $name;
    }

    private function atLeast(float $floor): float
    {
        $base = $this->transport->timeout;

        return $base > 0 ? max($base, $floor) : $base;
    }

    private static function queryKey(string $name): string
    {
        $constant = strtoupper((string) preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
        $key = Protocol::QUERY_KEYS[$constant] ?? null;

        if (!\is_string($key)) {
            throw new \LogicException(\sprintf(Messages::UNKNOWN_QUERY_KEY, $name));
        }

        return $key;
    }
}
