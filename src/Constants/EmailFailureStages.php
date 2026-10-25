<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class EmailFailureStages
{
    public const SCHEDULE = 'schedule';
    public const TRANSPORT = 'transport';

    public static function values(): array
    {
        return [self::SCHEDULE, self::TRANSPORT];
    }
}
