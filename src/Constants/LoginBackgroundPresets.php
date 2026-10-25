<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class LoginBackgroundPresets
{
    public const DUSK = 'dusk';
    public const MIST = 'mist';
    public const SAND = 'sand';
    public const NIGHT = 'night';
    public const MEADOW = 'meadow';
    public const DOTS = 'dots';
    public const BRUSH = 'brush';
    public const TRAIL = 'trail';
    public const EMBER = 'ember';
    public const CANVAS = 'canvas';
    public const BLOOM = 'bloom';
    public const FIELD = 'field';
    public const WANDERER = 'wanderer';
    public const GOLD = 'gold';

    public static function values(): array
    {
        return [
            self::DUSK,
            self::MIST,
            self::SAND,
            self::NIGHT,
            self::MEADOW,
            self::DOTS,
            self::BRUSH,
            self::TRAIL,
            self::EMBER,
            self::CANVAS,
            self::BLOOM,
            self::FIELD,
            self::WANDERER,
            self::GOLD,
        ];
    }
}
