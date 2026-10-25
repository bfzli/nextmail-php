<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ConnectorCallSources
{
    public const CHAT = 'chat';
    public const TASK = 'task';
    public const API = 'api';
    public const MCP = 'mcp';

    public static function values(): array
    {
        return [self::CHAT, self::TASK, self::API, self::MCP];
    }
}
