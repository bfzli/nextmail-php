<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class WebhookDeadLetterReplayOutcomes
{
    public const DELIVERED = 'delivered';
    public const FAILED = 'failed';
    public const REFUSED = 'refused';
    public const SKIPPED = 'skipped';

    public static function values(): array
    {
        return [self::DELIVERED, self::FAILED, self::REFUSED, self::SKIPPED];
    }
}
