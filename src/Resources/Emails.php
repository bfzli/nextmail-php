<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Exception\InvalidArgumentException;
use Nextmail\Internal\ApiPaths;
use Nextmail\Internal\Messages;
use Nextmail\Internal\Pagination;
use Nextmail\Internal\Wire;
use Nextmail\Result\BatchResult;
use Nextmail\Result\Page;

final class Emails extends Resource
{
    public function send(array $body, ?string $idempotencyKey = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            ApiPaths::EMAILS,
            'POST',
            body: Wire::email($body),
            idempotent: true,
            idempotencyKey: $idempotencyKey,
            repeatable: true,
            apiKey: $apiKey,
        );
    }

    public function sendRaw(array $body, ?string $idempotencyKey = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            ApiPaths::EMAILS_RAW,
            'POST',
            body: Wire::emailRaw($body),
            idempotent: true,
            idempotencyKey: $idempotencyKey,
            repeatable: true,
            apiKey: $apiKey,
        );
    }

    public function sendBatch(array $emails, ?string $idempotencyKey = null, #[\SensitiveParameter] ?string $apiKey = null): BatchResult
    {
        $wire = [];

        foreach ($emails as $email) {
            if (!\is_array($email)) {
                throw new InvalidArgumentException(Messages::BATCH_EMAIL_SHAPE);
            }

            $wire[] = Wire::email($email);
        }
        $result = $this->call(
            ApiPaths::EMAILS_BATCH,
            'POST',
            body: ['emails' => $wire],
            idempotent: true,
            idempotencyKey: $idempotencyKey,
            repeatable: true,
            apiKey: $apiKey,
        );
        $sent = $result['sent'] ?? null;
        $failed = $result['failed'] ?? null;

        return new BatchResult(Pagination::itemsOf($result), \is_int($sent) ? $sent : null, \is_int($failed) ? $failed : null);
    }

    public function translate(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::EMAILS_TRANSLATE, 'POST', body: $body, apiKey: $apiKey);
    }

    public function check(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::EMAILS_CHECK, 'POST', body: $body, apiKey: $apiKey);
    }

    public function list(
        string|array|null $status = null,
        ?string $from = null,
        ?string $broadcastId = null,
        string|\DateTimeInterface|null $scheduledFrom = null,
        string|\DateTimeInterface|null $scheduledTo = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?string $recipient = null,
        ?string $tag = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage(ApiPaths::EMAILS, $this->listQuery($status, $from, $broadcastId, $scheduledFrom, $scheduledTo, $since, $until, $recipient, $tag), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAll(
        string|array|null $status = null,
        ?string $from = null,
        ?string $broadcastId = null,
        string|\DateTimeInterface|null $scheduledFrom = null,
        string|\DateTimeInterface|null $scheduledTo = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?string $recipient = null,
        ?string $tag = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll(ApiPaths::EMAILS, $this->listQuery($status, $from, $broadcastId, $scheduledFrom, $scheduledTo, $since, $until, $recipient, $tag), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterate(
        string|array|null $status = null,
        ?string $from = null,
        ?string $broadcastId = null,
        string|\DateTimeInterface|null $scheduledFrom = null,
        string|\DateTimeInterface|null $scheduledTo = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?string $recipient = null,
        ?string $tag = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages(ApiPaths::EMAILS, $this->listQuery($status, $from, $broadcastId, $scheduledFrom, $scheduledTo, $since, $until, $recipient, $tag), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function get(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::EMAIL, id: $id), apiKey: $apiKey);
    }

    public function listEvents(
        string $id,
        ?string $address = null,
        ?string $messageId = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage($this->fill(ApiPaths::EMAIL_EVENTS, id: $id), $this->eventsQuery($address, $messageId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllEvents(
        string $id,
        ?string $address = null,
        ?string $messageId = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll($this->fill(ApiPaths::EMAIL_EVENTS, id: $id), $this->eventsQuery($address, $messageId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateEvents(
        string $id,
        ?string $address = null,
        ?string $messageId = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages($this->fill(ApiPaths::EMAIL_EVENTS, id: $id), $this->eventsQuery($address, $messageId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listEventsByMessageId(string $messageId, ?string $address = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage(ApiPaths::EMAILS_EVENTS, $this->eventsQuery($address, $messageId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllEventsByMessageId(string $messageId, ?string $address = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll(ApiPaths::EMAILS_EVENTS, $this->eventsQuery($address, $messageId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateEventsByMessageId(string $messageId, ?string $address = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages(ApiPaths::EMAILS_EVENTS, $this->eventsQuery($address, $messageId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function getTracking(string $id, ?string $address = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::EMAIL_TRACKING, id: $id), query: $this->query(address: $address), apiKey: $apiKey);
    }

    public function cancel(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::EMAIL_CANCEL, id: $id), 'POST', repeatable: true, apiKey: $apiKey);
    }

    public function reschedule(string $id, string|\DateTimeInterface $scheduledAt, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            $this->fill(ApiPaths::EMAIL, id: $id),
            'PATCH',
            body: ['scheduledAt' => $this->instant($scheduledAt)],
            repeatable: true,
            apiKey: $apiKey,
        );
    }

    public function update(string $id, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::EMAIL, id: $id), 'PATCH', body: Wire::recipients($patch), repeatable: true, apiKey: $apiKey);
    }

    public function compose(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::EMAILS_COMPOSE, 'POST', body: $body, apiKey: $apiKey);
    }

    public function rewrite(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::EMAILS_REWRITE, 'POST', body: $body, apiKey: $apiKey);
    }

    public function suggestSubject(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::EMAILS_SUBJECT, 'POST', body: $body, apiKey: $apiKey);
    }

    private function listQuery(
        string|array|null $status,
        ?string $from,
        ?string $broadcastId,
        string|\DateTimeInterface|null $scheduledFrom,
        string|\DateTimeInterface|null $scheduledTo,
        string|\DateTimeInterface|null $since,
        string|\DateTimeInterface|null $until,
        ?string $recipient,
        ?string $tag,
    ): array {
        return $this->query(
            status: $this->joined($status),
            from: $from,
            broadcastId: $broadcastId,
            scheduledFrom: $this->instant($scheduledFrom),
            scheduledTo: $this->instant($scheduledTo),
            since: $this->instant($since),
            until: $this->instant($until),
            recipient: $recipient,
            tag: $tag,
        );
    }

    private function eventsQuery(?string $address, ?string $messageId): array
    {
        return $this->query(address: $address, messageId: $messageId);
    }
}
