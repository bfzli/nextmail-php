<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ConnectorPauseReasons
{
    public const USER = 'user';
    public const PLAN = 'plan';

    public static function values(): array
    {
        return [self::USER, self::PLAN];
    }
}
