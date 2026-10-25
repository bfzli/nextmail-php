<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Internal\Pagination;
use Nextmail\Result\Page;

final class Rules extends Resource
{
    public function list(?bool $enabled = null, ?string $q = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage(ApiPaths::RULES, $this->query(enabled: $this->flag($enabled), q: $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAll(?bool $enabled = null, ?string $q = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll(ApiPaths::RULES, $this->query(enabled: $this->flag($enabled), q: $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterate(?bool $enabled = null, ?string $q = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages(ApiPaths::RULES, $this->query(enabled: $this->flag($enabled), q: $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function get(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::RULE, id: $id), apiKey: $apiKey);
    }

    public function create(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::RULES, 'POST', body: $body, apiKey: $apiKey);
    }

    public function update(string $id, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::RULE, id: $id), 'PATCH', body: $patch, apiKey: $apiKey);
    }

    public function delete(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::RULE, id: $id), 'DELETE', apiKey: $apiKey);
    }

    public function reorder(array $ruleIds, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        $envelope = $this->call(ApiPaths::RULES_REORDER, 'POST', body: ['ruleIds' => array_values($ruleIds)], repeatable: true, apiKey: $apiKey);

        return Pagination::itemsOf($envelope);
    }

    public function test(string $id, ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::RULE_TEST, id: $id), 'POST', body: $this->payload($body), repeatable: true, apiKey: $apiKey);
    }

    public function listRuns(?string $ruleId = null, string|array|null $ruleIds = null, ?string $threadId = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage(ApiPaths::RULE_RUNS, $this->runsQuery($ruleId, $ruleIds, $threadId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllRuns(?string $ruleId = null, string|array|null $ruleIds = null, ?string $threadId = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll(ApiPaths::RULE_RUNS, $this->runsQuery($ruleId, $ruleIds, $threadId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateRuns(?string $ruleId = null, string|array|null $ruleIds = null, ?string $threadId = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages(ApiPaths::RULE_RUNS, $this->runsQuery($ruleId, $ruleIds, $threadId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function stats(
        string|array|null $ruleIds = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?string $grain = null,
        ?int $offsetMinutes = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        $query = [...$this->windowQuery($since, $until), ...$this->query(ruleIds: $this->joined($ruleIds), grain: $grain, offsetMinutes: $offsetMinutes)];

        return $this->call(ApiPaths::RULES_STATS, query: $query, apiKey: $apiKey);
    }

    private function runsQuery(?string $ruleId, string|array|null $ruleIds, ?string $threadId): array
    {
        return $this->query(ruleId: $ruleId, ruleIds: $this->joined($ruleIds), threadId: $threadId);
    }
}
