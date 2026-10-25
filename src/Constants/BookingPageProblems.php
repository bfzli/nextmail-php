<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class BookingPageProblems
{
    public const SENDER = 'sender';
    public const HOST = 'host';
    public const HOURS = 'hours';

    public static function values(): array
    {
        return [self::SENDER, self::HOST, self::HOURS];
    }
}
