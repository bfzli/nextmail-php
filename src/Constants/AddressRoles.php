<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class AddressRoles
{
    public const OWNER = 'owner';
    public const MEMBER = 'member';
    public const VIEWER = 'viewer';

    public static function values(): array
    {
        return [self::OWNER, self::MEMBER, self::VIEWER];
    }
}
