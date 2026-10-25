<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ChatStopStatuses
{
    public const STOPPED = 'stopped';
    public const IDLE = 'idle';

    public static function values(): array
    {
        return [self::STOPPED, self::IDLE];
    }
}
