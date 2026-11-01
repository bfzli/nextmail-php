<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class MxAddressFamilies
{
    public const IPV4 = 'ipv4';
    public const IPV6 = 'ipv6';

    public static function values(): array
    {
        return [self::IPV4, self::IPV6];
    }
}
