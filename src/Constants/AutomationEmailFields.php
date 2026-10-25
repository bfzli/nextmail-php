<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class AutomationEmailFields
{
    public const FROM = 'from';
    public const SUBJECT = 'subject';
    public const TEXT = 'text';

    public static function values(): array
    {
        return [self::FROM, self::SUBJECT, self::TEXT];
    }
}
