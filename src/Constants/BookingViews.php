<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class BookingViews
{
    public const UPCOMING = 'upcoming';
    public const PENDING = 'pending';
    public const PAST = 'past';
    public const ENDED = 'ended';

    public static function values(): array
    {
        return [self::UPCOMING, self::PENDING, self::PAST, self::ENDED];
    }
}
