<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class AddressRouteTestSteps
{
    public const ADDRESS = 'address';
    public const ALIAS = 'alias';
    public const ROUTE = 'route';
    public const CATCH_ALL = 'catch_all';
    public const NONE = 'none';

    public static function values(): array
    {
        return [self::ADDRESS, self::ALIAS, self::ROUTE, self::CATCH_ALL, self::NONE];
    }
}
