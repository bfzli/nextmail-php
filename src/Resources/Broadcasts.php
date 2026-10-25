<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Result\Page;

final class Broadcasts extends Resource
{
    public function preview(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        $wire = array_intersect_key($body, ['audienceIds' => true, 'excludeAudienceIds' => true, 'segmentId' => true]);

        return $this->call(ApiPaths::BROADCASTS_PREVIEW, 'POST', body: $wire, repeatable: true, apiKey: $apiKey);
    }

    public function send(array $body, ?string $idempotencyKey = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        if (\array_key_exists('scheduledAt', $body)) {
            $body['scheduledAt'] = $this->instant($body['scheduledAt']);
        }

        return $this->call(
            ApiPaths::BROADCASTS,
            'POST',
            body: $body,
            idempotent: true,
            idempotencyKey: $idempotencyKey,
            repeatable: true,
            apiKey: $apiKey,
        );
    }

    public function list(?string $audienceId = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage(ApiPaths::BROADCASTS, $this->query(audienceId: $audienceId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAll(?string $audienceId = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll(ApiPaths::BROADCASTS, $this->query(audienceId: $audienceId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterate(?string $audienceId = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages(ApiPaths::BROADCASTS, $this->query(audienceId: $audienceId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function get(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::BROADCAST, id: $id), apiKey: $apiKey);
    }

    public function stats(
        string $id,
        ?string $grain = null,
        ?int $offsetMinutes = null,
        ?int $days = null,
        ?int $minutes = null,
        string|\DateTimeInterface|null $since = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->call(
            $this->fill(ApiPaths::BROADCAST_STATS, id: $id),
            query: $this->query(grain: $grain, offsetMinutes: $offsetMinutes, days: $days, minutes: $minutes, since: $this->instant($since)),
            apiKey: $apiKey,
        );
    }

    public function analytics(
        string|array|null $broadcastIds = null,
        ?int $days = null,
        ?int $minutes = null,
        string|\DateTimeInterface|null $since = null,
        ?string $grain = null,
        ?int $offsetMinutes = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        $query = $this->query(
            broadcastIds: $this->joined($broadcastIds),
            days: $days,
            minutes: $minutes,
            grain: $grain,
            offsetMinutes: $offsetMinutes,
            since: $this->instant($since),
        );

        return $this->call(ApiPaths::BROADCASTS_ANALYTICS, query: $query, apiKey: $apiKey);
    }

    public function listRecipients(string $id, ?string $filter = null, ?string $q = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage($this->fill(ApiPaths::BROADCAST_RECIPIENTS, id: $id), $this->query(filter: $filter, q: $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllRecipients(string $id, ?string $filter = null, ?string $q = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll($this->fill(ApiPaths::BROADCAST_RECIPIENTS, id: $id), $this->query(filter: $filter, q: $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateRecipients(string $id, ?string $filter = null, ?string $q = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages($this->fill(ApiPaths::BROADCAST_RECIPIENTS, id: $id), $this->query(filter: $filter, q: $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function getRecipient(string $id, string $emailId, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::BROADCAST_RECIPIENT, id: $id, emailId: $emailId), apiKey: $apiKey);
    }

    public function cancel(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::BROADCAST_CANCEL, id: $id), 'POST', repeatable: true, apiKey: $apiKey);
    }

    public function createDraft(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::BROADCAST_DRAFTS, 'POST', body: $body, apiKey: $apiKey);
    }

    public function update(string $id, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            $this->fill(ApiPaths::BROADCAST, id: $id),
            'PATCH',
            body: $this->scheduled($patch),
            repeatable: true,
            apiKey: $apiKey,
        );
    }

    public function sendDraft(string $id, ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            $this->fill(ApiPaths::BROADCAST_SEND, id: $id),
            'POST',
            body: $this->scheduled($this->payload($body)),
            apiKey: $apiKey,
        );
    }

    public function duplicate(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::BROADCAST_DUPLICATE, id: $id), 'POST', apiKey: $apiKey);
    }

    public function resend(string $id, ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            $this->fill(ApiPaths::BROADCAST_RESEND, id: $id),
            'POST',
            body: $this->scheduled($this->payload($body)),
            apiKey: $apiKey,
        );
    }

    public function sendTest(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::BROADCASTS_TEST, 'POST', body: $body, apiKey: $apiKey);
    }

    private function scheduled(array $body): array
    {
        if (\array_key_exists('scheduledAt', $body)) {
            $body['scheduledAt'] = $this->instant($body['scheduledAt']);
        }

        return $body;
    }
}
