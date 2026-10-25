<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;

final class Subscriptions extends Resource
{
    public function list(
        ?string $status = null,
        ?string $q = null,
        ?string $sort = null,
        ?bool $suggested = null,
        ?int $limit = null,
        ?int $offset = null,
        ?string $address = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->call(ApiPaths::SUBSCRIPTIONS, query: $this->listQuery($status, $q, $sort, $suggested, $limit, $offset, $address), apiKey: $apiKey);
    }

    public function listDomains(
        ?string $status = null,
        ?string $q = null,
        ?string $sort = null,
        ?bool $suggested = null,
        ?int $limit = null,
        ?int $offset = null,
        ?string $address = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->call(ApiPaths::SUBSCRIPTION_DOMAINS, query: $this->listQuery($status, $q, $sort, $suggested, $limit, $offset, $address), apiKey: $apiKey);
    }

    public function unsubscribe(string $id, ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SUBSCRIPTION_UNSUBSCRIBE, id: $id), 'POST', body: $this->payload($body), apiKey: $apiKey);
    }

    public function unsubscribeDomain(string $domain, ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SUBSCRIPTION_DOMAIN_UNSUBSCRIBE, domain: $domain), 'POST', body: $this->payload($body), apiKey: $apiKey);
    }

    public function move(string $id, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SUBSCRIPTION_MOVE, id: $id), 'POST', body: $body, repeatable: true, apiKey: $apiKey);
    }

    public function keep(array $ids, ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::SUBSCRIPTIONS_BATCH_KEEP, 'POST', body: $this->batch($ids, $body), repeatable: true, apiKey: $apiKey);
    }

    public function unsubscribeMany(array $ids, ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::SUBSCRIPTIONS_BATCH_UNSUBSCRIBE, 'POST', body: $this->batch($ids, $body), apiKey: $apiKey);
    }

    public function moveMany(array $ids, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::SUBSCRIPTIONS_BATCH_MOVE, 'POST', body: $this->batch($ids, $body), repeatable: true, apiKey: $apiKey);
    }

    private function listQuery(?string $status, ?string $q, ?string $sort, ?bool $suggested, ?int $limit, ?int $offset, ?string $address): array
    {
        return $this->query(status: $status, q: $q, sort: $sort, suggested: $this->flag($suggested), limit: $limit, offset: $offset, address: $address);
    }

    private function batch(array $ids, ?array $body): array
    {
        return ['ids' => array_values($ids), ...$this->payload($body)];
    }
}
