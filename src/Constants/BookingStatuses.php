<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class BookingStatuses
{
    public const PENDING = 'pending';
    public const CONFIRMED = 'confirmed';
    public const DECLINED = 'declined';
    public const CANCELLED = 'cancelled';

    public static function values(): array
    {
        return [self::PENDING, self::CONFIRMED, self::DECLINED, self::CANCELLED];
    }
}
