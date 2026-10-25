<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ConnectedMailboxMethods
{
    public const IMAP = 'imap';
    public const MICROSOFT = 'microsoft';

    public static function values(): array
    {
        return [self::IMAP, self::MICROSOFT];
    }
}
