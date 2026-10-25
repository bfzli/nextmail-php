<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class PushPlatforms
{
    public const IOS = 'ios';
    public const ANDROID = 'android';

    public static function values(): array
    {
        return [self::IOS, self::ANDROID];
    }
}
