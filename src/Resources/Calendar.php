<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Internal\Protocol;
use Nextmail\Result\Page;

final class Calendar extends Resource
{
    public function listEvents(
        string|\DateTimeInterface $from,
        string|\DateTimeInterface $to,
        ?string $timezone = null,
        ?bool $includeTeam = null,
        ?string $q = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage(ApiPaths::CALENDAR_EVENTS, $this->rangeQuery($from, $to, $timezone, $includeTeam, $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllEvents(
        string|\DateTimeInterface $from,
        string|\DateTimeInterface $to,
        ?string $timezone = null,
        ?bool $includeTeam = null,
        ?string $q = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll(ApiPaths::CALENDAR_EVENTS, $this->rangeQuery($from, $to, $timezone, $includeTeam, $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateEvents(
        string|\DateTimeInterface $from,
        string|\DateTimeInterface $to,
        ?string $timezone = null,
        ?bool $includeTeam = null,
        ?string $q = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages(ApiPaths::CALENDAR_EVENTS, $this->rangeQuery($from, $to, $timezone, $includeTeam, $q), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function getEvent(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CALENDAR_EVENT, id: $id), apiKey: $apiKey);
    }

    public function getEventIcs(string $id, #[\SensitiveParameter] ?string $apiKey = null): string
    {
        return $this->text($this->fill(ApiPaths::CALENDAR_EVENT_ICS, id: $id), Protocol::CONTENT_TYPES['CALENDAR'], $apiKey);
    }

    public function createEvent(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::CALENDAR_EVENTS, 'POST', body: $this->eventWire($body), apiKey: $apiKey);
    }

    public function updateEvent(string $id, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CALENDAR_EVENT, id: $id), 'PATCH', body: $this->eventWire($patch), apiKey: $apiKey);
    }

    public function deleteEvent(
        string $id,
        ?string $scope = null,
        string|\DateTimeInterface|null $occurrenceStart = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->call(
            $this->fill(ApiPaths::CALENDAR_EVENT, id: $id),
            'DELETE',
            query: $this->query(scope: $scope, occurrenceStart: $this->instant($occurrenceStart)),
            apiKey: $apiKey,
        );
    }

    public function cancelEvent(string $id, ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CALENDAR_EVENT_CANCEL, id: $id), 'POST', body: $this->scopeWire($this->payload($body)), apiKey: $apiKey);
    }

    public function hideEvent(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CALENDAR_EVENT_HIDE, id: $id), 'POST', apiKey: $apiKey);
    }

    public function unhideEvent(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CALENDAR_EVENT_UNHIDE, id: $id), 'POST', apiKey: $apiKey);
    }

    public function freeBusy(
        array $emails,
        string|\DateTimeInterface $from,
        string|\DateTimeInterface $to,
        ?string $timezone = null,
        ?int $durationMinutes = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->call(
            ApiPaths::CALENDAR_FREE_BUSY,
            query: $this->query(
                from: $this->instant($from),
                to: $this->instant($to),
                timezone: $timezone,
                emails: $this->joined($emails),
                durationMinutes: $durationMinutes,
            ),
            apiKey: $apiKey,
        );
    }

    public function respondToEvent(string $id, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CALENDAR_EVENT_RESPOND, id: $id), 'POST', body: $this->answerWire($body), apiKey: $apiKey);
    }

    public function declineProposal(string $id, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CALENDAR_EVENT_DECLINE_PROPOSAL, id: $id), 'POST', body: $body, apiKey: $apiKey);
    }

    public function listFeeds(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList(ApiPaths::CALENDAR_FEEDS, apiKey: $apiKey);
    }

    public function createFeed(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::CALENDAR_FEEDS, 'POST', body: $body, apiKey: $apiKey);
    }

    public function resetFeed(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CALENDAR_FEED_RESET, id: $id), 'POST', apiKey: $apiKey);
    }

    public function deleteFeed(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CALENDAR_FEED, id: $id), 'DELETE', apiKey: $apiKey);
    }

    public function listSubscriptions(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList(ApiPaths::CALENDAR_SUBSCRIPTIONS, apiKey: $apiKey);
    }

    public function createSubscription(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::CALENDAR_SUBSCRIPTIONS, 'POST', body: $body, apiKey: $apiKey);
    }

    public function updateSubscription(string $id, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CALENDAR_SUBSCRIPTION, id: $id), 'PATCH', body: $patch, apiKey: $apiKey);
    }

    public function refreshSubscription(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CALENDAR_SUBSCRIPTION_REFRESH, id: $id), 'POST', apiKey: $apiKey);
    }

    public function deleteSubscription(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CALENDAR_SUBSCRIPTION, id: $id), 'DELETE', apiKey: $apiKey);
    }

    public function importIcs(mixed $data, ?string $filename = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            ApiPaths::CALENDAR_IMPORTS,
            'POST',
            query: $this->query(filename: $filename),
            raw: $data,
            contentType: Protocol::CONTENT_TYPES['CALENDAR'],
            apiKey: $apiKey,
        );
    }

    public function listImports(?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage(ApiPaths::CALENDAR_IMPORTS, limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllImports(?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll(ApiPaths::CALENDAR_IMPORTS, limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateImports(?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages(ApiPaths::CALENDAR_IMPORTS, limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function getImport(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CALENDAR_IMPORT, id: $id), apiKey: $apiKey);
    }

    public function undoImport(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CALENDAR_IMPORT_UNDO, id: $id), 'POST', apiKey: $apiKey);
    }

    private function rangeQuery(string|\DateTimeInterface $from, string|\DateTimeInterface $to, ?string $timezone, ?bool $includeTeam, ?string $q): array
    {
        return $this->query(from: $this->instant($from), to: $this->instant($to), timezone: $timezone, includeTeam: $this->flag($includeTeam), q: $q);
    }

    private function eventWire(array $body): array
    {
        foreach (['start', 'end'] as $field) {
            if (\array_key_exists($field, $body)) {
                $body[$field] = $this->instant($body[$field]);
            }
        }

        return $this->scopeWire($body);
    }

    private function scopeWire(array $body): array
    {
        if (\array_key_exists('occurrenceStart', $body)) {
            $body['occurrenceStart'] = $this->instant($body['occurrenceStart']);
        }

        return $body;
    }

    private function answerWire(array $body): array
    {
        foreach (['proposedStart', 'proposedEnd'] as $field) {
            if (\array_key_exists($field, $body)) {
                $body[$field] = $this->instant($body[$field]);
            }
        }

        return $body;
    }
}
