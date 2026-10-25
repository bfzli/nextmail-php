<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ConnectorScopes
{
    public const ACCOUNT = 'account';
    public const WORKSPACE = 'workspace';

    public static function values(): array
    {
        return [self::ACCOUNT, self::WORKSPACE];
    }
}
