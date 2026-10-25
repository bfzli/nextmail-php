<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class AddressExpiryActions
{
    public const STOP = 'stop';
    public const DELETE = 'delete';

    public static function values(): array
    {
        return [self::STOP, self::DELETE];
    }
}
