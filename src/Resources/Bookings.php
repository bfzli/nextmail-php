<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Result\Page;

final class Bookings extends Resource
{
    public function listPages(
        ?string $q = null,
        ?string $status = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?string $sort = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        $query = $this->query(q: $q, status: $status, since: $this->instant($since), until: $this->instant($until), sort: $sort);

        return $this->fetchList(ApiPaths::BOOKING_PAGES, $query, $apiKey);
    }

    public function getPage(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::BOOKING_PAGE, id: $id), apiKey: $apiKey);
    }

    public function createPage(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::BOOKING_PAGES, 'POST', body: $body, apiKey: $apiKey);
    }

    public function updatePage(string $id, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::BOOKING_PAGE, id: $id), 'PATCH', body: $patch, repeatable: true, apiKey: $apiKey);
    }

    public function uploadBackground(string $id, mixed $data, ?string $contentType = null, ?array $crop = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            $this->fill(ApiPaths::BOOKING_PAGE_BACKGROUND, id: $id),
            'PUT',
            query: $this->cropQuery($crop),
            raw: $data,
            contentType: $this->rawContentType($data, $contentType),
            repeatable: true,
            timeout: $this->uploadTimeout(),
            apiKey: $apiKey,
        );
    }

    public function removeBackground(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::BOOKING_PAGE_BACKGROUND, id: $id), 'DELETE', repeatable: true, apiKey: $apiKey);
    }

    public function deletePage(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::BOOKING_PAGE, id: $id), 'DELETE', apiKey: $apiKey);
    }

    public function listTimes(
        string $id,
        string|\DateTimeInterface|null $from = null,
        string|\DateTimeInterface|null $to = null,
        ?int $durationMinutes = null,
        ?string $bookingId = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->call(
            $this->fill(ApiPaths::BOOKING_PAGE_TIMES, id: $id),
            query: $this->query(from: $this->instant($from), to: $this->instant($to), durationMinutes: $durationMinutes, bookingId: $bookingId),
            apiKey: $apiKey,
        );
    }

    public function list(
        ?string $view = null,
        ?string $pageId = null,
        string|array|null $pageIds = null,
        ?string $q = null,
        string|\DateTimeInterface|null $from = null,
        string|\DateTimeInterface|null $to = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage(ApiPaths::BOOKINGS, $this->listQuery($view, $pageId, $pageIds, $q, $from, $to), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAll(
        ?string $view = null,
        ?string $pageId = null,
        string|array|null $pageIds = null,
        ?string $q = null,
        string|\DateTimeInterface|null $from = null,
        string|\DateTimeInterface|null $to = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll(ApiPaths::BOOKINGS, $this->listQuery($view, $pageId, $pageIds, $q, $from, $to), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterate(
        ?string $view = null,
        ?string $pageId = null,
        string|array|null $pageIds = null,
        ?string $q = null,
        string|\DateTimeInterface|null $from = null,
        string|\DateTimeInterface|null $to = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages(ApiPaths::BOOKINGS, $this->listQuery($view, $pageId, $pageIds, $q, $from, $to), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function get(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::BOOKING, id: $id), apiKey: $apiKey);
    }

    public function approve(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::BOOKING_APPROVE, id: $id), 'POST', apiKey: $apiKey);
    }

    public function decline(string $id, ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::BOOKING_DECLINE, id: $id), 'POST', body: $this->payload($body), apiKey: $apiKey);
    }

    public function cancel(string $id, ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::BOOKING_CANCEL, id: $id), 'POST', body: $this->payload($body), apiKey: $apiKey);
    }

    public function reschedule(string $id, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        $wire = \array_key_exists('start', $body) ? ['start' => $this->instant($body['start'])] : [];

        if (\array_key_exists('reason', $body)) {
            $wire['reason'] = $body['reason'];
        }

        return $this->call($this->fill(ApiPaths::BOOKING_RESCHEDULE, id: $id), 'POST', body: $wire, apiKey: $apiKey);
    }

    public function resendEmail(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::BOOKING_RESEND, id: $id), 'POST', apiKey: $apiKey);
    }

    public function analytics(
        string|array|null $pageIds = null,
        ?int $days = null,
        ?int $minutes = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?string $grain = null,
        ?int $offsetMinutes = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        $query = [
            ...$this->query(pageIds: $this->ids($pageIds), days: $days, minutes: $minutes, grain: $grain, offsetMinutes: $offsetMinutes),
            ...$this->windowQuery($since, $until),
        ];

        return $this->call(ApiPaths::BOOKINGS_ANALYTICS, query: $query, apiKey: $apiKey);
    }

    private function listQuery(
        ?string $view,
        ?string $pageId,
        string|array|null $pageIds,
        ?string $q,
        string|\DateTimeInterface|null $from,
        string|\DateTimeInterface|null $to,
    ): array {
        return $this->query(view: $view, pageId: $pageId, pageIds: $this->ids($pageIds), q: $q, from: $this->instant($from), to: $this->instant($to));
    }

    private function ids(string|array|null $ids): mixed
    {
        return $ids === null || $ids === [] || $ids === '' ? null : $this->joined($ids);
    }
}
