<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class SubscriptionBatchRefusals
{
    public const ALREADY_UNSUBSCRIBED = 'already_unsubscribed';
    public const NO_METHOD = 'no_method';

    public static function values(): array
    {
        return [self::ALREADY_UNSUBSCRIBED, self::NO_METHOD];
    }
}
