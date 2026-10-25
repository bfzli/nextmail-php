<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ChatStopReasons
{
    public const STOP_REQUESTED = 'stop_requested';
    public const SUPERSEDED = 'superseded';
    public const TIME_LIMIT = 'time_limit';

    public static function values(): array
    {
        return [self::STOP_REQUESTED, self::SUPERSEDED, self::TIME_LIMIT];
    }
}
