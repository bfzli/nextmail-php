<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class SegmentMatches
{
    public const ALL = 'all';
    public const ANY = 'any';

    public static function values(): array
    {
        return [self::ALL, self::ANY];
    }
}
