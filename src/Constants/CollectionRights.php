<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class CollectionRights
{
    public const OWNER = 'owner';
    public const WRITE = 'write';
    public const READ = 'read';

    public static function values(): array
    {
        return [self::OWNER, self::WRITE, self::READ];
    }
}
