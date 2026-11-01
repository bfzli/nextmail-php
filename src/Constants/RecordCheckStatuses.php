<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class RecordCheckStatuses
{
    public const PASS = 'pass';
    public const WARN = 'warn';
    public const FAIL = 'fail';
    public const MISSING = 'missing';

    public static function values(): array
    {
        return [self::PASS, self::WARN, self::FAIL, self::MISSING];
    }
}
