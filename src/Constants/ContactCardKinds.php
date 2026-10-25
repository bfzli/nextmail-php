<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ContactCardKinds
{
    public const INDIVIDUAL = 'individual';
    public const GROUP = 'group';

    public static function values(): array
    {
        return [self::INDIVIDUAL, self::GROUP];
    }
}
