<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class TaskAutonomies
{
    public const ASK = 'ask';
    public const ORGANIZE = 'organize';
    public const REPLY = 'reply';

    public static function values(): array
    {
        return [self::ASK, self::ORGANIZE, self::REPLY];
    }
}
