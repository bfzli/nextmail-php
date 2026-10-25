<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ConnectorAccessLevels
{
    public const READ = 'read';
    public const FULL = 'full';

    public static function values(): array
    {
        return [self::READ, self::FULL];
    }
}
