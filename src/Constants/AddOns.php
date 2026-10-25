<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class AddOns
{
    public const DEDICATED_IP = 'dedicated-ip';

    public static function values(): array
    {
        return [self::DEDICATED_IP];
    }
}
