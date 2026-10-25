<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class AutomationRunEvents
{
    public const ENTERED = 'entered';
    public const STEP = 'step';
    public const COMPLETED = 'completed';
    public const EXITED = 'exited';

    public static function values(): array
    {
        return [self::ENTERED, self::STEP, self::COMPLETED, self::EXITED];
    }
}
