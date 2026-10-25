<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ConnectedMailboxPauseReasons
{
    public const BY_PERSON = 'by-person';
    public const SIGN_IN = 'sign-in';
    public const UNREACHABLE = 'unreachable';

    public static function values(): array
    {
        return [self::BY_PERSON, self::SIGN_IN, self::UNREACHABLE];
    }
}
