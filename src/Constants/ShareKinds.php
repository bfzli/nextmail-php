<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ShareKinds
{
    public const TEMPLATE = 'template';
    public const FORM = 'form';
    public const AUTOMATION = 'automation';

    public static function values(): array
    {
        return [self::TEMPLATE, self::FORM, self::AUTOMATION];
    }
}
