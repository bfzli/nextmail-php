<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class SpfNodeErrors
{
    public const MISSING = 'missing';
    public const MULTIPLE = 'multiple';
    public const LOOP = 'loop';
    public const LOOKUP_FAILED = 'lookup-failed';
    public const SKIPPED = 'skipped';

    public static function values(): array
    {
        return [self::MISSING, self::MULTIPLE, self::LOOP, self::LOOKUP_FAILED, self::SKIPPED];
    }
}
