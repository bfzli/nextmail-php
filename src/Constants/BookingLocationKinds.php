<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class BookingLocationKinds
{
    public const VIDEO = 'video';
    public const PHONE = 'phone';
    public const IN_PERSON = 'in-person';
    public const NONE = 'none';

    public static function values(): array
    {
        return [self::VIDEO, self::PHONE, self::IN_PERSON, self::NONE];
    }
}
