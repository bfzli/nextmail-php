<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class RecordCheckSeverities
{
    public const ERROR = 'error';
    public const WARNING = 'warning';
    public const NOTICE = 'notice';
    public const PASS = 'pass';

    public static function values(): array
    {
        return [self::ERROR, self::WARNING, self::NOTICE, self::PASS];
    }
}
