<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Internal\Pagination;
use Nextmail\Result\NotificationPage;

final class Notifications extends Resource
{
    public function list(?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): NotificationPage
    {
        $envelope = $this->call(ApiPaths::NOTIFICATIONS, query: $this->query(limit: $limit, cursor: $cursor), apiKey: $apiKey);
        $nextCursor = Pagination::cursorOf($envelope['nextCursor'] ?? null);
        $unreadCount = $envelope['unreadCount'] ?? null;

        return new NotificationPage(
            Pagination::itemsOf($envelope),
            \is_int($unreadCount) ? $unreadCount : 0,
            Pagination::hasMore($envelope, $nextCursor),
            $nextCursor,
        );
    }

    public function unreadCount(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::NOTIFICATIONS_UNREAD_COUNT, apiKey: $apiKey);
    }

    public function markRead(array $ids, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::NOTIFICATIONS_READ, 'POST', body: ['ids' => array_values($ids)], repeatable: true, apiKey: $apiKey);
    }

    public function markAllRead(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::NOTIFICATIONS_READ_ALL, 'POST', repeatable: true, apiKey: $apiKey);
    }

    public function clear(?bool $declineInvitations = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            ApiPaths::NOTIFICATIONS_CLEAR,
            'POST',
            body: $declineInvitations === null ? [] : ['declineInvitations' => $declineInvitations],
            repeatable: true,
            apiKey: $apiKey,
        );
    }
}
