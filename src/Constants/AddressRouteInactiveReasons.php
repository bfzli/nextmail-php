<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class AddressRouteInactiveReasons
{
    public const SWITCHED_OFF = 'switched_off';
    public const TARGET_REMOVED = 'target_removed';
    public const TARGET_DISABLED = 'target_disabled';
    public const WEBHOOK_DELETED = 'webhook_deleted';
    public const WEBHOOK_DISABLED = 'webhook_disabled';
    public const REWRITE_DOMAIN_REMOVED = 'rewrite_domain_removed';
    public const FORWARD_PENDING = 'forward_pending';
    public const FORWARD_REFUSED = 'forward_refused';

    public static function values(): array
    {
        return [
            self::SWITCHED_OFF,
            self::TARGET_REMOVED,
            self::TARGET_DISABLED,
            self::WEBHOOK_DELETED,
            self::WEBHOOK_DISABLED,
            self::REWRITE_DOMAIN_REMOVED,
            self::FORWARD_PENDING,
            self::FORWARD_REFUSED,
        ];
    }
}
