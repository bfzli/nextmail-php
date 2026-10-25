<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class TaskToolkits
{
    public const CONTACTS = 'contacts';
    public const AUDIENCES = 'audiences';
    public const TEMPLATES = 'templates';
    public const TRACKING = 'tracking';
    public const TRANSLATE = 'translate';
    public const FILES = 'files';
    public const NOTES = 'notes';
    public const DRAFTS = 'drafts';
    public const SENT = 'sent';
    public const INSIGHTS = 'insights';
    public const SUBSCRIPTIONS = 'subscriptions';
    public const CALENDAR = 'calendar';
    public const KNOWLEDGE = 'knowledge';
    public const CONNECTORS = 'connectors';
    public const WEB = 'web';

    public static function values(): array
    {
        return [
            self::CONTACTS,
            self::AUDIENCES,
            self::TEMPLATES,
            self::TRACKING,
            self::TRANSLATE,
            self::FILES,
            self::NOTES,
            self::DRAFTS,
            self::SENT,
            self::INSIGHTS,
            self::SUBSCRIPTIONS,
            self::CALENDAR,
            self::KNOWLEDGE,
            self::CONNECTORS,
            self::WEB,
        ];
    }
}
