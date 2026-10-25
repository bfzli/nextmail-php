<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ChatToolCallStatuses
{
    public const PENDING_APPROVAL = 'pending_approval';
    public const DONE = 'done';
    public const DENIED = 'denied';
    public const INTERRUPTED = 'interrupted';

    public static function values(): array
    {
        return [self::PENDING_APPROVAL, self::DONE, self::DENIED, self::INTERRUPTED];
    }
}
