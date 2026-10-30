<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class LiveEventTypes
{
    public const MESSAGE_RECEIVED = 'message.received';
    public const MESSAGE_SENT = 'message.sent';
    public const THREAD_CHANGED = 'thread.changed';
    public const THREAD_DELETED = 'thread.deleted';
    public const MESSAGE_STATUS_CHANGED = 'message.status_changed';

    public static function values(): array
    {
        return [
            self::MESSAGE_RECEIVED,
            self::MESSAGE_SENT,
            self::THREAD_CHANGED,
            self::THREAD_DELETED,
            self::MESSAGE_STATUS_CHANGED,
        ];
    }
}
