<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ConnectedMailboxStatuses
{
    public const ACTIVE = 'active';
    public const PAUSED = 'paused';
    public const NEEDS_SIGN_IN = 'needs-sign-in';
    public const FAILING = 'failing';

    public static function values(): array
    {
        return [self::ACTIVE, self::PAUSED, self::NEEDS_SIGN_IN, self::FAILING];
    }
}
