<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class BookingQuestionKinds
{
    public const TEXT = 'text';
    public const LONG_TEXT = 'long-text';
    public const PHONE = 'phone';
    public const CHOICE = 'choice';
    public const CHECKBOX = 'checkbox';

    public static function values(): array
    {
        return [self::TEXT, self::LONG_TEXT, self::PHONE, self::CHOICE, self::CHECKBOX];
    }
}
