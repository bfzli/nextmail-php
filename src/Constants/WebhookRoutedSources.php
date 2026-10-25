<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class WebhookRoutedSources
{
    public const ADDRESS = 'address';
    public const ROUTE = 'route';

    public static function values(): array
    {
        return [self::ADDRESS, self::ROUTE];
    }
}
