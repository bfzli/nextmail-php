<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class CalendarEditScopes
{
    public const OCCURRENCE = 'occurrence';
    public const FOLLOWING = 'following';
    public const SERIES = 'series';

    public static function values(): array
    {
        return [self::OCCURRENCE, self::FOLLOWING, self::SERIES];
    }
}
