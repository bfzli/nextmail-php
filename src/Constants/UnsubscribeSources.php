<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class UnsubscribeSources
{
    public const LINK = 'link';
    public const ONE_CLICK = 'one_click';
    public const MANUAL = 'manual';
    public const COMPLAINT = 'complaint';
    public const IMPORT = 'import';

    public static function values(): array
    {
        return [self::LINK, self::ONE_CLICK, self::MANUAL, self::COMPLAINT, self::IMPORT];
    }
}
