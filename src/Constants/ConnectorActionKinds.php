<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ConnectorActionKinds
{
    public const READ = 'read';
    public const CHANGE = 'change';

    public static function values(): array
    {
        return [self::READ, self::CHANGE];
    }
}
