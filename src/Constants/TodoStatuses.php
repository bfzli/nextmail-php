<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class TodoStatuses
{
    public const NEEDS_ACTION = 'NEEDS-ACTION';
    public const IN_PROCESS = 'IN-PROCESS';
    public const COMPLETED = 'COMPLETED';
    public const CANCELLED = 'CANCELLED';

    public static function values(): array
    {
        return [self::NEEDS_ACTION, self::IN_PROCESS, self::COMPLETED, self::CANCELLED];
    }
}
