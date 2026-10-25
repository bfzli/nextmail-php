<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ChatMessageOrders
{
    public const ASC = 'asc';
    public const DESC = 'desc';

    public static function values(): array
    {
        return [self::ASC, self::DESC];
    }
}
