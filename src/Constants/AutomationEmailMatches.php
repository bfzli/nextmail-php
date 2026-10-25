<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class AutomationEmailMatches
{
    public const ANY = 'any';
    public const REPLY = 'reply';
    public const NEW = 'new';

    public static function values(): array
    {
        return [self::ANY, self::REPLY, self::NEW];
    }
}
