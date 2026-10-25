<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class SubscriptionStatuses
{
    public const ACTIVE = 'active';
    public const KEPT = 'kept';
    public const UNSUBSCRIBED = 'unsubscribed';

    public static function values(): array
    {
        return [self::ACTIVE, self::KEPT, self::UNSUBSCRIBED];
    }
}
