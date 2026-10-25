<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Exception\InvalidArgumentException;
use Nextmail\Internal\ApiPaths;
use Nextmail\Internal\Messages;
use Nextmail\Internal\RawBody;
use Nextmail\Result\Page;

final class Imports extends Resource
{
    public function list(
        ?string $addressId = null,
        ?string $source = null,
        ?string $status = null,
        ?string $search = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage(ApiPaths::IMPORTS, $this->listQuery($addressId, $source, $status, $search), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAll(
        ?string $addressId = null,
        ?string $source = null,
        ?string $status = null,
        ?string $search = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll(ApiPaths::IMPORTS, $this->listQuery($addressId, $source, $status, $search), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterate(
        ?string $addressId = null,
        ?string $source = null,
        ?string $status = null,
        ?string $search = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages(ApiPaths::IMPORTS, $this->listQuery($addressId, $source, $status, $search), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function get(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::IMPORT, id: $id), apiKey: $apiKey);
    }

    public function create(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::IMPORTS, 'POST', body: $body, apiKey: $apiKey);
    }

    public function uploadState(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::IMPORT_UPLOAD, id: $id), apiKey: $apiKey);
    }

    public function uploadChunk(string $id, int $file, int $chunk, mixed $data, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::IMPORT_FILE_CHUNK, id: $id, file: $file, chunk: $chunk), 'PUT', raw: $data, repeatable: true, apiKey: $apiKey);
    }

    public function start(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::IMPORT_START, id: $id), 'POST', repeatable: true, apiKey: $apiKey);
    }

    public function cancel(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::IMPORT_CANCEL, id: $id), 'POST', apiKey: $apiKey);
    }

    public function listFailures(string $id, ?int $after = null, ?int $limit = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::IMPORT_FAILURES, id: $id), query: ['after' => $after, 'limit' => $limit], apiKey: $apiKey);
    }

    public function deleteUpload(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::IMPORT_UPLOAD, id: $id), 'DELETE', apiKey: $apiKey);
    }

    public function discoverMailbox(string $email, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::IMPORT_MAILBOX_SETTINGS, query: $this->query(email: $email), apiKey: $apiKey);
    }

    public function checkMailbox(#[\SensitiveParameter] array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::IMPORT_MAILBOX_CHECK, 'POST', body: $body, apiKey: $apiKey);
    }

    public function connectMailbox(#[\SensitiveParameter] array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::IMPORT_MAILBOX, 'POST', body: $body, apiKey: $apiKey);
    }

    public function resume(string $id, #[\SensitiveParameter] ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::IMPORT_RESUME, id: $id), 'POST', body: $this->payload($body), apiKey: $apiKey);
    }

    public function importFiles(array $input, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        $files = array_map(self::source(...), array_values(\is_array($input['files'] ?? null) ? $input['files'] : []));
        $body = [
            'addressId' => $input['addressId'] ?? null,
            'files' => array_map(static fn(array $file): array => ['name' => $file['name'], 'bytes' => RawBody::size($file['data'])], $files),
        ];

        if (\array_key_exists('options', $input)) {
            $body['options'] = $input['options'];
        }

        $created = $this->create($body, $apiKey);

        if ($files === []) {
            return $created;
        }

        $id = \is_string($created['id'] ?? null) ? $created['id'] : '';
        $progress = \is_callable($input['onProgress'] ?? null) ? $input['onProgress'] : null;

        $this->uploadFiles($id, $created, $files, $progress, $apiKey);

        return $this->start($id, $apiKey);
    }

    private function listQuery(?string $addressId, ?string $source, ?string $status, ?string $search): array
    {
        return ['addressId' => $addressId, ...$this->query(source: $source, status: $status, search: $search)];
    }

    private function uploadFiles(string $id, array $created, array $files, ?callable $progress, #[\SensitiveParameter] ?string $apiKey): void
    {
        $chunkBytes = \is_int($created['chunkBytes'] ?? null) && $created['chunkBytes'] > 0 ? $created['chunkBytes'] : null;
        $total = \is_int($created['totalBytes'] ?? null) ? $created['totalBytes'] : 0;
        $planned = \is_array($created['files'] ?? null) ? array_values($created['files']) : [];
        $uploaded = 0;

        foreach (array_values($files) as $index => $file) {
            if (!\is_array($file)) {
                continue;
            }

            $size = RawBody::size($file['data'] ?? null);
            $plan = $planned[$index] ?? null;
            $chunks = \is_array($plan) && \is_int($plan['chunks'] ?? null) ? $plan['chunks'] : 1;

            for ($chunk = 0; $chunk < $chunks; $chunk += 1) {
                $begin = $chunkBytes === null ? 0 : $chunk * $chunkBytes;
                $end = $chunkBytes === null ? $size : min($size, $begin + $chunkBytes);
                $length = max(0, $end - $begin);

                $this->uploadChunk($id, $index, $chunk, RawBody::slice($file['data'] ?? null, $begin, $length), $apiKey);

                $uploaded += $length;

                if ($progress !== null) {
                    $progress($uploaded, $total);
                }
            }
        }
    }

    private static function source(mixed $file): array
    {
        if (!\is_array($file) || !\is_string($file['name'] ?? null) || !RawBody::isReadable($file['data'] ?? null)) {
            throw new InvalidArgumentException(Messages::IMPORT_FILE_SHAPE);
        }

        return ['name' => $file['name'], 'data' => RawBody::sliceable($file['data'])];
    }
}
