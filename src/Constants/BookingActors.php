<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class BookingActors
{
    public const HOST = 'host';
    public const GUEST = 'guest';

    public static function values(): array
    {
        return [self::HOST, self::GUEST];
    }
}
