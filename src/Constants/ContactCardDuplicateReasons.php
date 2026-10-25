<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ContactCardDuplicateReasons
{
    public const EMAIL = 'email';
    public const PHONE = 'phone';
    public const NAME = 'name';

    public static function values(): array
    {
        return [self::EMAIL, self::PHONE, self::NAME];
    }
}
