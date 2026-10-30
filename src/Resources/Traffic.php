<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Result\Page;

final class Traffic extends Resource
{
    public function list(
        ?string $domainId = null,
        ?string $direction = null,
        string|array|null $outcomes = null,
        ?string $address = null,
        ?string $recipient = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage(ApiPaths::TRAFFIC, $this->trafficQuery($domainId, $direction, $outcomes, $address, $recipient, $since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAll(
        ?string $domainId = null,
        ?string $direction = null,
        string|array|null $outcomes = null,
        ?string $address = null,
        ?string $recipient = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll(ApiPaths::TRAFFIC, $this->trafficQuery($domainId, $direction, $outcomes, $address, $recipient, $since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterate(
        ?string $domainId = null,
        ?string $direction = null,
        string|array|null $outcomes = null,
        ?string $address = null,
        ?string $recipient = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages(ApiPaths::TRAFFIC, $this->trafficQuery($domainId, $direction, $outcomes, $address, $recipient, $since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    private function trafficQuery(
        ?string $domainId,
        ?string $direction,
        string|array|null $outcomes,
        ?string $address,
        ?string $recipient,
        string|\DateTimeInterface|null $since,
        string|\DateTimeInterface|null $until,
    ): array {
        $outcome = $outcomes === [] ? null : $this->joined($outcomes);

        return [...$this->windowQuery($since, $until), ...$this->query(domainId: $domainId, direction: $direction, outcome: $outcome, address: $address, recipient: $recipient)];
    }
}
