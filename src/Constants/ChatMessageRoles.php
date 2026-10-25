<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ChatMessageRoles
{
    public const USER = 'user';
    public const ASSISTANT = 'assistant';

    public static function values(): array
    {
        return [self::USER, self::ASSISTANT];
    }
}
