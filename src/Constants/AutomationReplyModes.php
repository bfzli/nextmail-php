<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class AutomationReplyModes
{
    public const TEXT = 'text';
    public const AI = 'ai';

    public static function values(): array
    {
        return [self::TEXT, self::AI];
    }
}
