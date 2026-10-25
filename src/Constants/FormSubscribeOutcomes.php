<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class FormSubscribeOutcomes
{
    public const ADDED = 'added';
    public const PENDING = 'pending';

    public static function values(): array
    {
        return [self::ADDED, self::PENDING];
    }
}
