<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class LiveSendStatuses
{
    public const DELIVERED = 'delivered';
    public const DELIVERY_DELAYED = 'delivery_delayed';
    public const BOUNCED = 'bounced';
    public const COMPLAINED = 'complained';
    public const FAILED = 'failed';
    public const SUPPRESSED = 'suppressed';
    public const CANCELLED = 'cancelled';

    public static function values(): array
    {
        return [
            self::DELIVERED,
            self::DELIVERY_DELAYED,
            self::BOUNCED,
            self::COMPLAINED,
            self::FAILED,
            self::SUPPRESSED,
            self::CANCELLED,
        ];
    }
}
