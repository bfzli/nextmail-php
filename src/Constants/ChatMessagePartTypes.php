<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ChatMessagePartTypes
{
    public const TEXT = 'text';
    public const TOOL_CALL = 'tool_call';
    public const FILE = 'file';

    public static function values(): array
    {
        return [self::TEXT, self::TOOL_CALL, self::FILE];
    }
}
