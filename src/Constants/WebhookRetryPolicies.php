<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class WebhookRetryPolicies
{
    public const STANDARD = 'standard';
    public const EXTENDED = 'extended';

    public static function values(): array
    {
        return [self::STANDARD, self::EXTENDED];
    }
}
