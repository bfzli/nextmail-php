<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ConnectorFailures
{
    public const EXPIRED = 'expired';
    public const REVOKED = 'revoked';
    public const FAILED = 'failed';
    public const DISABLED = 'disabled';

    public static function values(): array
    {
        return [self::EXPIRED, self::REVOKED, self::FAILED, self::DISABLED];
    }
}
