<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ConnectorStatuses
{
    public const PENDING = 'pending';
    public const ACTIVE = 'active';
    public const EXPIRED = 'expired';
    public const PAUSED = 'paused';

    public static function values(): array
    {
        return [self::PENDING, self::ACTIVE, self::EXPIRED, self::PAUSED];
    }
}
