<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class TaskPauseReasons
{
    public const USER = 'user';
    public const FAILURES = 'failures';
    public const PLAN_LIMIT = 'plan_limit';

    public static function values(): array
    {
        return [self::USER, self::FAILURES, self::PLAN_LIMIT];
    }
}
