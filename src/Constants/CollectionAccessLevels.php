<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class CollectionAccessLevels
{
    public const READ = 'read';
    public const WRITE = 'write';

    public static function values(): array
    {
        return [self::READ, self::WRITE];
    }
}
