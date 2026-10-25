<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class TaskCadences
{
    public const HOURLY = 'hourly';
    public const DAILY = 'daily';
    public const MONTHLY = 'monthly';

    public static function values(): array
    {
        return [self::HOURLY, self::DAILY, self::MONTHLY];
    }
}
