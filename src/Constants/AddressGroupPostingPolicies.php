<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class AddressGroupPostingPolicies
{
    public const ANYONE = 'anyone';
    public const MEMBERS = 'members';
    public const WORKSPACE = 'workspace';

    public static function values(): array
    {
        return [self::ANYONE, self::MEMBERS, self::WORKSPACE];
    }
}
