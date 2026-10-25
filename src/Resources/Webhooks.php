<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Result\Page;

final class Webhooks extends Resource
{
    public function list(?string $q = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage(ApiPaths::WEBHOOKS, $this->query(q: $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAll(?string $q = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll(ApiPaths::WEBHOOKS, $this->query(q: $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterate(?string $q = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages(ApiPaths::WEBHOOKS, $this->query(q: $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function get(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::WEBHOOK, id: $id), apiKey: $apiKey);
    }

    public function create(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::WEBHOOKS, 'POST', body: $body, apiKey: $apiKey);
    }

    public function update(string $id, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::WEBHOOK, id: $id), 'PATCH', body: $patch, repeatable: true, apiKey: $apiKey);
    }

    public function delete(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::WEBHOOK, id: $id), 'DELETE', apiKey: $apiKey);
    }

    public function rotateSecret(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::WEBHOOK_ROTATE_SECRET, id: $id), 'POST', apiKey: $apiKey);
    }

    public function test(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::WEBHOOK_TEST, id: $id), 'POST', apiKey: $apiKey);
    }

    public function listDeliveries(
        string $id,
        ?string $status = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage($this->fill(ApiPaths::WEBHOOK_DELIVERIES, id: $id), $this->deliveryQuery($status, $since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllDeliveries(
        string $id,
        ?string $status = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll($this->fill(ApiPaths::WEBHOOK_DELIVERIES, id: $id), $this->deliveryQuery($status, $since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateDeliveries(
        string $id,
        ?string $status = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages($this->fill(ApiPaths::WEBHOOK_DELIVERIES, id: $id), $this->deliveryQuery($status, $since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function getDelivery(string $id, string $deliveryId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::WEBHOOK_DELIVERY, id: $id, deliveryId: $deliveryId), apiKey: $apiKey);
    }

    public function replayDelivery(string $id, string $deliveryId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::WEBHOOK_DELIVERY_REPLAY, id: $id, deliveryId: $deliveryId), 'POST', apiKey: $apiKey);
    }

    public function listDeadLetters(
        string $id,
        ?string $status = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage($this->fill(ApiPaths::WEBHOOK_DEAD_LETTERS, id: $id), $this->deadLetterQuery($status, $since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllDeadLetters(
        string $id,
        ?string $status = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll($this->fill(ApiPaths::WEBHOOK_DEAD_LETTERS, id: $id), $this->deadLetterQuery($status, $since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateDeadLetters(
        string $id,
        ?string $status = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages($this->fill(ApiPaths::WEBHOOK_DEAD_LETTERS, id: $id), $this->deadLetterQuery($status, $since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function replayDeadLetters(string $id, ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::WEBHOOK_DEAD_LETTERS_REPLAY, id: $id), 'POST', body: $this->payload($body), apiKey: $apiKey);
    }

    public function discardDeadLetter(string $id, string $deadLetterId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::WEBHOOK_DEAD_LETTER, id: $id, deadLetterId: $deadLetterId), 'DELETE', repeatable: true, apiKey: $apiKey);
    }

    public function listWorkspaceDeliveries(
        string|array|null $endpointIds = null,
        ?string $status = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage(ApiPaths::WEBHOOKS_DELIVERIES, $this->workspaceDeliveryQuery($endpointIds, $status, $since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllWorkspaceDeliveries(
        string|array|null $endpointIds = null,
        ?string $status = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll(ApiPaths::WEBHOOKS_DELIVERIES, $this->workspaceDeliveryQuery($endpointIds, $status, $since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateWorkspaceDeliveries(
        string|array|null $endpointIds = null,
        ?string $status = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages(ApiPaths::WEBHOOKS_DELIVERIES, $this->workspaceDeliveryQuery($endpointIds, $status, $since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listActivity(
        string $id,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage($this->fill(ApiPaths::WEBHOOK_ACTIVITY, id: $id), $this->windowQuery($since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllActivity(
        string $id,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll($this->fill(ApiPaths::WEBHOOK_ACTIVITY, id: $id), $this->windowQuery($since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateActivity(
        string $id,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages($this->fill(ApiPaths::WEBHOOK_ACTIVITY, id: $id), $this->windowQuery($since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listWorkspaceActivity(
        string|array|null $endpointIds = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage(ApiPaths::WEBHOOKS_ACTIVITY, $this->workspaceActivityQuery($endpointIds, $since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllWorkspaceActivity(
        string|array|null $endpointIds = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll(ApiPaths::WEBHOOKS_ACTIVITY, $this->workspaceActivityQuery($endpointIds, $since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateWorkspaceActivity(
        string|array|null $endpointIds = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages(ApiPaths::WEBHOOKS_ACTIVITY, $this->workspaceActivityQuery($endpointIds, $since, $until), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listEvents(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::WEBHOOKS_EVENTS, apiKey: $apiKey);
    }

    public function stats(
        string|array|null $endpointIds = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?string $grain = null,
        ?int $offsetMinutes = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        $query = [...$this->windowQuery($since, $until), ...$this->query(endpointIds: $this->joined($endpointIds), grain: $grain, offsetMinutes: $offsetMinutes)];

        return $this->call(ApiPaths::WEBHOOKS_STATS, query: $query, apiKey: $apiKey);
    }

    private function deliveryQuery(?string $status, string|\DateTimeInterface|null $since, string|\DateTimeInterface|null $until): array
    {
        return [...$this->windowQuery($since, $until), ...$this->query(status: $status)];
    }

    private function deadLetterQuery(?string $status, string|\DateTimeInterface|null $since, string|\DateTimeInterface|null $until): array
    {
        return [...$this->windowQuery($since, $until), ...$this->query(status: $status)];
    }

    private function workspaceDeliveryQuery(
        string|array|null $endpointIds,
        ?string $status,
        string|\DateTimeInterface|null $since,
        string|\DateTimeInterface|null $until,
    ): array {
        return [...$this->deliveryQuery($status, $since, $until), ...$this->query(endpointIds: $this->joined($endpointIds))];
    }

    private function workspaceActivityQuery(
        string|array|null $endpointIds,
        string|\DateTimeInterface|null $since,
        string|\DateTimeInterface|null $until,
    ): array {
        return [...$this->windowQuery($since, $until), ...$this->query(endpointIds: $this->joined($endpointIds))];
    }
}
