<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class TaskTriggerKinds
{
    public const SCHEDULE = 'schedule';
    public const MAIL = 'mail';
    public const MANUAL = 'manual';

    public static function values(): array
    {
        return [self::SCHEDULE, self::MAIL, self::MANUAL];
    }
}
