<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class TaskModels
{
    public const STANDARD = 'standard';
    public const ADVANCED = 'advanced';

    public static function values(): array
    {
        return [self::STANDARD, self::ADVANCED];
    }
}
