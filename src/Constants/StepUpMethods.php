<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class StepUpMethods
{
    public const EMAIL = 'email';
    public const TOTP = 'totp';

    public static function values(): array
    {
        return [self::EMAIL, self::TOTP];
    }
}
