<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class DirectoryPersonStates
{
    public const MEMBER = 'member';
    public const INVITED = 'invited';
    public const WAITING = 'waiting';
    public const INACTIVE = 'inactive';

    public static function values(): array
    {
        return [self::MEMBER, self::INVITED, self::WAITING, self::INACTIVE];
    }
}
