<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class SubscriptionSorts
{
    public const RECENT = 'recent';
    public const MOST = 'most';
    public const EMAILS = 'emails';
    public const READ = 'read';
    public const UNREAD = 'unread';
    public const NAME = 'name';

    public static function values(): array
    {
        return [self::RECENT, self::MOST, self::EMAILS, self::READ, self::UNREAD, self::NAME];
    }
}
