<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class AppHostSenderWaits
{
    public const LOGO = 'logo';
    public const SIGNING = 'signing';

    public static function values(): array
    {
        return [self::LOGO, self::SIGNING];
    }
}
