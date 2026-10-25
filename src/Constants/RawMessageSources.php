<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class RawMessageSources
{
    public const ORIGINAL = 'original';
    public const REBUILT = 'rebuilt';

    public static function values(): array
    {
        return [self::ORIGINAL, self::REBUILT];
    }
}
