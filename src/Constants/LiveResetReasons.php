<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class LiveResetReasons
{
    public const EXPIRED = 'expired';
    public const UNKNOWN = 'unknown';

    public static function values(): array
    {
        return [self::EXPIRED, self::UNKNOWN];
    }
}
