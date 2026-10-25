<?php

declare(strict_types=1);

namespace Nextmail\Internal;

use Nextmail\Exception\InvalidArgumentException;

final class ImageCrop
{
    private const SIDES = ['x', 'y', 'width', 'height'];

    private const EXACT_PRECISION = 53;

    private const FIXED_LIMIT = 1.0e21;

    private const HALF_DIGIT = 5;

    public static function text(?array $crop): ?string
    {
        if ($crop === null) {
            return null;
        }

        $sides = [];

        foreach (self::SIDES as $side) {
            $value = $crop[$side] ?? null;

            if (!\is_int($value) && !\is_float($value)) {
                throw new InvalidArgumentException(Messages::IMAGE_CROP_SHAPE);
            }

            $sides[] = self::side((float) $value);
        }

        return implode(Protocol::IMAGE_CROP_SEPARATOR, $sides);
    }

    public static function side(float $value): string
    {
        if (!is_finite($value) || abs($value) >= self::FIXED_LIMIT) {
            return Wire::numberText($value);
        }

        return Wire::numberText((float) self::fixed($value));
    }

    private static function fixed(float $value): string
    {
        $decimals = Protocol::IMAGE_CROP_DECIMALS;
        $exact = \sprintf('%.' . self::EXACT_PRECISION . 'F', abs($value));
        $point = (int) strpos($exact, '.');
        $kept = substr($exact, 0, $point) . substr($exact, $point + 1, $decimals);
        $roundsUp = (int) substr($exact, $point + 1 + $decimals, 1) >= self::HALF_DIGIT;
        $digits = $roundsUp ? self::incremented($kept) : $kept;
        $whole = \strlen($digits) - $decimals;

        return ($value < 0 ? '-' : '') . substr($digits, 0, $whole) . '.' . substr($digits, $whole);
    }

    private static function incremented(string $digits): string
    {
        $at = \strlen($digits) - 1;

        while ($at >= 0 && $digits[$at] === '9') {
            $digits[$at] = '0';
            --$at;
        }

        return $at < 0 ? '1' . $digits : substr_replace($digits, (string) ((int) $digits[$at] + 1), $at, 1);
    }
}
