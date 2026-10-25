<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ConnectorAuthKinds
{
    public const SIGN_IN = 'sign-in';
    public const KEY = 'key';

    public static function values(): array
    {
        return [self::SIGN_IN, self::KEY];
    }
}
