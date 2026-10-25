<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class SegmentOperators
{
    public const IS = 'is';
    public const IS_NOT = 'is_not';
    public const CONTAINS = 'contains';
    public const NOT_CONTAINS = 'not_contains';
    public const ENDS_WITH = 'ends_with';
    public const IS_SET = 'is_set';
    public const IS_NOT_SET = 'is_not_set';
    public const WITHIN_DAYS = 'within_days';
    public const NOT_WITHIN_DAYS = 'not_within_days';
    public const IN = 'in';
    public const NOT_IN = 'not_in';

    public static function values(): array
    {
        return [
            self::IS,
            self::IS_NOT,
            self::CONTAINS,
            self::NOT_CONTAINS,
            self::ENDS_WITH,
            self::IS_SET,
            self::IS_NOT_SET,
            self::WITHIN_DAYS,
            self::NOT_WITHIN_DAYS,
            self::IN,
            self::NOT_IN,
        ];
    }
}
