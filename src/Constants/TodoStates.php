<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class TodoStates
{
    public const OPEN = 'open';
    public const DONE = 'done';
    public const ALL = 'all';

    public static function values(): array
    {
        return [self::OPEN, self::DONE, self::ALL];
    }
}
