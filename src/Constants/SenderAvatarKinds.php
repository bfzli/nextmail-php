<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class SenderAvatarKinds
{
    public const MEMBER = 'member';
    public const CONTACT = 'contact';
    public const LOOKUP = 'lookup';
    public const GENERATED = 'generated';

    public static function values(): array
    {
        return [self::MEMBER, self::CONTACT, self::LOOKUP, self::GENERATED];
    }
}
