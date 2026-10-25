<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class GroupMemberKinds
{
    public const ADDRESS = 'address';
    public const EMAIL = 'email';

    public static function values(): array
    {
        return [self::ADDRESS, self::EMAIL];
    }
}
