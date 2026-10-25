<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class TaskNotifyModes
{
    public const ALWAYS = 'always';
    public const ATTENTION = 'attention';
    public const NEVER = 'never';

    public static function values(): array
    {
        return [self::ALWAYS, self::ATTENTION, self::NEVER];
    }
}
