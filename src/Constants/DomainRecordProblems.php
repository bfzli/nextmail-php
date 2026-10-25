<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class DomainRecordProblems
{
    public const NOTHING_PUBLISHED = 'nothing-published';
    public const DIFFERENT_VALUE = 'different-value';
    public const DOUBLED_NAME = 'doubled-name';
    public const QUOTED_VALUE = 'quoted-value';
    public const RELATIVE_TARGET = 'relative-target';
    public const PROXIED = 'proxied';
    public const SEVERAL_SPF = 'several-spf';
    public const SEVERAL_DMARC = 'several-dmarc';
    public const UNREADABLE = 'unreadable';

    public static function values(): array
    {
        return [
            self::NOTHING_PUBLISHED,
            self::DIFFERENT_VALUE,
            self::DOUBLED_NAME,
            self::QUOTED_VALUE,
            self::RELATIVE_TARGET,
            self::PROXIED,
            self::SEVERAL_SPF,
            self::SEVERAL_DMARC,
            self::UNREADABLE,
        ];
    }
}
