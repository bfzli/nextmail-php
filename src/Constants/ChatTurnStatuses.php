<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ChatTurnStatuses
{
    public const COMPLETED = 'completed';
    public const AWAITING_APPROVAL = 'awaiting_approval';
    public const STOPPED = 'stopped';
    public const FAILED = 'failed';

    public static function values(): array
    {
        return [self::COMPLETED, self::AWAITING_APPROVAL, self::STOPPED, self::FAILED];
    }
}
