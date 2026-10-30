<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class AutomationThreadRoles
{
    public const STARTED = 'started';
    public const SENT = 'sent';

    public static function values(): array
    {
        return [self::STARTED, self::SENT];
    }
}
