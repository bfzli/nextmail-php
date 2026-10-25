<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class FormFieldErrors
{
    public const REQUIRED = 'required';
    public const EMAIL = 'email';
    public const NUMBER = 'number';
    public const MIN = 'min';
    public const MAX = 'max';
    public const TOO_SHORT = 'too_short';
    public const TOO_LONG = 'too_long';
    public const URL = 'url';
    public const DATE = 'date';
    public const PHONE = 'phone';
    public const OPTION = 'option';
    public const UNDELIVERABLE = 'undeliverable';
    public const DISPOSABLE = 'disposable';
    public const MAILBOX_NOT_FOUND = 'mailbox_not_found';

    public static function values(): array
    {
        return [
            self::REQUIRED,
            self::EMAIL,
            self::NUMBER,
            self::MIN,
            self::MAX,
            self::TOO_SHORT,
            self::TOO_LONG,
            self::URL,
            self::DATE,
            self::PHONE,
            self::OPTION,
            self::UNDELIVERABLE,
            self::DISPOSABLE,
            self::MAILBOX_NOT_FOUND,
        ];
    }
}
