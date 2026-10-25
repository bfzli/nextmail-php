<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ImportHistoryStatuses
{
    public const QUEUED = 'queued';
    public const RUNNING = 'running';
    public const PAUSED = 'paused';
    public const DONE = 'done';
    public const FAILED = 'failed';
    public const CANCELLED = 'cancelled';

    public static function values(): array
    {
        return [self::QUEUED, self::RUNNING, self::PAUSED, self::DONE, self::FAILED, self::CANCELLED];
    }
}
