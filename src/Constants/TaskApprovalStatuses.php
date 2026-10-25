<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class TaskApprovalStatuses
{
    public const PENDING = 'pending';
    public const APPROVED = 'approved';
    public const DENIED = 'denied';
    public const EXPIRED = 'expired';
    public const CANCELLED = 'cancelled';

    public static function values(): array
    {
        return [self::PENDING, self::APPROVED, self::DENIED, self::EXPIRED, self::CANCELLED];
    }
}
