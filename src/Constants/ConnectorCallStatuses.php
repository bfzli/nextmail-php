<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ConnectorCallStatuses
{
    public const OK = 'ok';
    public const FAILED = 'failed';
    public const REFUSED = 'refused';

    public static function values(): array
    {
        return [self::OK, self::FAILED, self::REFUSED];
    }
}
