<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class TrafficOutcomes
{
    public const DELIVERED = 'delivered';
    public const DEFERRED = 'deferred';
    public const BOUNCED = 'bounced';
    public const SUPPRESSED = 'suppressed';
    public const COMPLAINED = 'complained';
    public const REJECTED = 'rejected';
    public const FAILED = 'failed';
    public const FORWARDED = 'forwarded';
    public const FILED = 'filed';
    public const SPAM = 'spam';
    public const ROUTED = 'routed';
    public const REFUSED = 'refused';
    public const DROPPED = 'dropped';
    public const REPORT = 'report';

    public static function values(): array
    {
        return [
            self::DELIVERED,
            self::DEFERRED,
            self::BOUNCED,
            self::SUPPRESSED,
            self::COMPLAINED,
            self::REJECTED,
            self::FAILED,
            self::FORWARDED,
            self::FILED,
            self::SPAM,
            self::ROUTED,
            self::REFUSED,
            self::DROPPED,
            self::REPORT,
        ];
    }
}
