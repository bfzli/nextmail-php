<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class BookingPageSorts
{
    public const OLDEST = 'oldest';
    public const NEWEST = 'newest';
    public const NAME = 'name';
    public const UPCOMING = 'upcoming';

    public static function values(): array
    {
        return [self::OLDEST, self::NEWEST, self::NAME, self::UPCOMING];
    }
}
