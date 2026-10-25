<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class SendingStreamStatuses
{
    public const ACTIVE = 'active';
    public const PAUSED = 'paused';

    public static function values(): array
    {
        return [self::ACTIVE, self::PAUSED];
    }
}
