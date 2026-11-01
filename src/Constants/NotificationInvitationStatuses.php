<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class NotificationInvitationStatuses
{
    public const OPEN = 'open';
    public const ACCEPTED = 'accepted';
    public const DECLINED = 'declined';
    public const WITHDRAWN = 'withdrawn';
    public const EXPIRED = 'expired';

    public static function values(): array
    {
        return [self::OPEN, self::ACCEPTED, self::DECLINED, self::WITHDRAWN, self::EXPIRED];
    }
}
