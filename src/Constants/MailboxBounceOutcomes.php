<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class MailboxBounceOutcomes
{
    public const FAILED = 'failed';
    public const DELAYED = 'delayed';
    public const DELIVERED = 'delivered';
    public const RELAYED = 'relayed';
    public const EXPANDED = 'expanded';

    public static function values(): array
    {
        return [self::FAILED, self::DELAYED, self::DELIVERED, self::RELAYED, self::EXPANDED];
    }
}
