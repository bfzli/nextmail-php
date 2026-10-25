<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class SendingStreamPauseReasons
{
    public const BOUNCE_RATE = 'bounce_rate';
    public const COMPLAINT_RATE = 'complaint_rate';

    public static function values(): array
    {
        return [self::BOUNCE_RATE, self::COMPLAINT_RATE];
    }
}
