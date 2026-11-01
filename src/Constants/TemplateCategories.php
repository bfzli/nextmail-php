<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class TemplateCategories
{
    public const ACCOUNT = 'account';
    public const COMMERCE = 'commerce';
    public const NOTIFY = 'notify';
    public const MARKETING = 'marketing';
    public const EVENTS = 'events';
    public const HOSPITALITY = 'hospitality';
    public const HEALTH = 'health';
    public const EDUCATION = 'education';
    public const REAL_ESTATE = 'real-estate';
    public const NONPROFIT = 'nonprofit';
    public const TRAVEL = 'travel';
    public const RECRUITING = 'recruiting';
    public const COMMUNITY = 'community';

    public static function values(): array
    {
        return [
            self::ACCOUNT,
            self::COMMERCE,
            self::NOTIFY,
            self::MARKETING,
            self::EVENTS,
            self::HOSPITALITY,
            self::HEALTH,
            self::EDUCATION,
            self::REAL_ESTATE,
            self::NONPROFIT,
            self::TRAVEL,
            self::RECRUITING,
            self::COMMUNITY,
        ];
    }
}
