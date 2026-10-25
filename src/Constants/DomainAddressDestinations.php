<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class DomainAddressDestinations
{
    public const MAILBOX = 'mailbox';
    public const FORWARD = 'forward';
    public const WEBHOOK = 'webhook';
    public const GROUP = 'group';

    public static function values(): array
    {
        return [self::MAILBOX, self::FORWARD, self::WEBHOOK, self::GROUP];
    }
}
