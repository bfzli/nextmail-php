<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Result\Page;

final class Suppressions extends Resource
{
    public function list(?string $q = null, ?string $reason = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage(ApiPaths::SUPPRESSIONS, $this->query(q: $q, reason: $reason), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAll(?string $q = null, ?string $reason = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll(ApiPaths::SUPPRESSIONS, $this->query(q: $q, reason: $reason), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterate(?string $q = null, ?string $reason = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages(ApiPaths::SUPPRESSIONS, $this->query(q: $q, reason: $reason), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function get(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SUPPRESSION, id: $id), apiKey: $apiKey);
    }

    public function add(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::SUPPRESSIONS, 'POST', body: $body, repeatable: true, apiKey: $apiKey);
    }

    public function remove(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SUPPRESSION, id: $id), 'DELETE', apiKey: $apiKey);
    }

    public function listUnsubscribes(?string $q = null, ?string $source = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage(ApiPaths::SUPPRESSION_UNSUBSCRIBES, $this->query(q: $q, source: $source), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function addUnsubscribe(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::SUPPRESSION_UNSUBSCRIBES, 'POST', body: $body, repeatable: true, apiKey: $apiKey);
    }

    public function removeUnsubscribe(string $email, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SUPPRESSION_UNSUBSCRIBE, email: $email), 'DELETE', apiKey: $apiKey);
    }
}
