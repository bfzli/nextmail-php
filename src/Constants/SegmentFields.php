<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class SegmentFields
{
    public const EMAIL = 'email';
    public const NAME = 'name';
    public const SOURCE = 'source';
    public const CREATED = 'created';
    public const AUDIENCE = 'audience';
    public const OPENED = 'opened';
    public const CLICKED = 'clicked';
    public const ENGAGED = 'engaged';
    public const EVENT = 'event';
    public const ATTRIBUTE = 'attribute';

    public static function values(): array
    {
        return [
            self::EMAIL,
            self::NAME,
            self::SOURCE,
            self::CREATED,
            self::AUDIENCE,
            self::OPENED,
            self::CLICKED,
            self::ENGAGED,
            self::EVENT,
            self::ATTRIBUTE,
        ];
    }
}
