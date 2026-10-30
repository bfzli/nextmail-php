<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class TrafficDirections
{
    public const INBOUND = 'inbound';
    public const OUTBOUND = 'outbound';

    public static function values(): array
    {
        return [self::INBOUND, self::OUTBOUND];
    }
}
