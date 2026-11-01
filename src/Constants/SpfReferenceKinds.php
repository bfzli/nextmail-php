<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class SpfReferenceKinds
{
    public const INCLUDE = 'include';
    public const REDIRECT = 'redirect';

    public static function values(): array
    {
        return [self::INCLUDE, self::REDIRECT];
    }
}
