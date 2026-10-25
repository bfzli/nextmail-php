<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class DomainDeletedReasons
{
    public const REMOVED = 'removed';
    public const NEVER_VERIFIED = 'never_verified';
    public const MOVED = 'moved';

    public static function values(): array
    {
        return [self::REMOVED, self::NEVER_VERIFIED, self::MOVED];
    }
}
