<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Result\Page;

final class ShareLinks extends Resource
{
    public function list(?string $kind = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage(ApiPaths::SHARE_LINKS, $this->query(kind: $kind), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAll(?string $kind = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll(ApiPaths::SHARE_LINKS, $this->query(kind: $kind), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterate(?string $kind = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages(ApiPaths::SHARE_LINKS, $this->query(kind: $kind), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function get(string $kind, string $itemId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SHARE_LINK, kind: $kind, itemId: $itemId), apiKey: $apiKey);
    }

    public function set(string $kind, string $itemId, ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SHARE_LINK, kind: $kind, itemId: $itemId), 'PUT', body: $this->payload($body), repeatable: true, apiKey: $apiKey);
    }

    public function delete(string $kind, string $itemId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SHARE_LINK, kind: $kind, itemId: $itemId), 'DELETE', apiKey: $apiKey);
    }
}
