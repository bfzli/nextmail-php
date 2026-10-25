<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class AddressRouteActions
{
    public const DELIVER = 'deliver';
    public const FORWARD = 'forward';
    public const WEBHOOK = 'webhook';
    public const REWRITE = 'rewrite';

    public static function values(): array
    {
        return [self::DELIVER, self::FORWARD, self::WEBHOOK, self::REWRITE];
    }
}
