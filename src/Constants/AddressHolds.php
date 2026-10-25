<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class AddressHolds
{
    public const PAUSED = 'paused';
    public const DISABLED = 'disabled';

    public static function values(): array
    {
        return [self::PAUSED, self::DISABLED];
    }
}
