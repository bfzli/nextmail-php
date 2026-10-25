<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class SessionDeviceKinds
{
    public const BROWSER = 'browser';
    public const APP = 'app';
    public const UNKNOWN = 'unknown';

    public static function values(): array
    {
        return [self::BROWSER, self::APP, self::UNKNOWN];
    }
}
