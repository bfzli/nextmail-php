<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class SpfQualifiers
{
    public const PASS = '+';
    public const FAIL = '-';
    public const SOFT_FAIL = '~';
    public const NEUTRAL = '?';

    public static function values(): array
    {
        return [self::PASS, self::FAIL, self::SOFT_FAIL, self::NEUTRAL];
    }
}
