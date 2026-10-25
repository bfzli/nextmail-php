<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class AutomationAddressAccepts
{
    public const VALID = 'valid';
    public const VALID_OR_RISKY = 'valid_or_risky';

    public static function values(): array
    {
        return [self::VALID, self::VALID_OR_RISKY];
    }
}
