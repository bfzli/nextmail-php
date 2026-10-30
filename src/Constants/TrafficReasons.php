<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class TrafficReasons
{
    public const UNKNOWN_RECIPIENT = 'unknown_recipient';
    public const ADDRESS_LIMITS = 'address_limits';
    public const BLOCKED_SENDER = 'blocked_sender';
    public const RULE = 'rule';
    public const GROUP_POLICY = 'group_policy';
    public const UNREADABLE = 'unreadable';
    public const TOO_LARGE = 'too_large';
    public const REPORT_REFUSED = 'report_refused';

    public static function values(): array
    {
        return [
            self::UNKNOWN_RECIPIENT,
            self::ADDRESS_LIMITS,
            self::BLOCKED_SENDER,
            self::RULE,
            self::GROUP_POLICY,
            self::UNREADABLE,
            self::TOO_LARGE,
            self::REPORT_REFUSED,
        ];
    }
}
