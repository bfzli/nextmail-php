<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class TaskRunErrors
{
    public const AI_LIMIT = 'ai_limit';
    public const AI_UNAVAILABLE = 'ai_unavailable';
    public const NO_PROGRESS = 'no_progress';
    public const ATTEMPTS = 'attempts';

    public static function values(): array
    {
        return [self::AI_LIMIT, self::AI_UNAVAILABLE, self::NO_PROGRESS, self::ATTEMPTS];
    }
}
