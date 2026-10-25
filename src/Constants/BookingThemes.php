<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class BookingThemes
{
    public const AUTO = 'auto';
    public const LIGHT = 'light';
    public const DARK = 'dark';

    public static function values(): array
    {
        return [self::AUTO, self::LIGHT, self::DARK];
    }
}
