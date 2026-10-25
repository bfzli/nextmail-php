<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class CalendarFeedModes
{
    public const FULL = 'full';
    public const BUSY = 'busy';

    public static function values(): array
    {
        return [self::FULL, self::BUSY];
    }
}
