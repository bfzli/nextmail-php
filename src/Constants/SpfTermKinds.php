<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class SpfTermKinds
{
    public const MECHANISM = 'mechanism';
    public const MODIFIER = 'modifier';
    public const UNKNOWN = 'unknown';

    public static function values(): array
    {
        return [self::MECHANISM, self::MODIFIER, self::UNKNOWN];
    }
}
