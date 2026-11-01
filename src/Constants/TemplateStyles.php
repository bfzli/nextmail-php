<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class TemplateStyles
{
    public const MINIMAL = 'minimal';
    public const MODERN = 'modern';
    public const BOLD = 'bold';
    public const CLASSIC = 'classic';
    public const DARK = 'dark';
    public const SOFT = 'soft';

    public static function values(): array
    {
        return [self::MINIMAL, self::MODERN, self::BOLD, self::CLASSIC, self::DARK, self::SOFT];
    }
}
