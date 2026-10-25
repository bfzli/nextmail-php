<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class WebhookDeadLetterStatuses
{
    public const OPEN = 'open';
    public const REPLAYED = 'replayed';
    public const DISCARDED = 'discarded';

    public static function values(): array
    {
        return [self::OPEN, self::REPLAYED, self::DISCARDED];
    }
}
