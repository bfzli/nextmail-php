<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class CalendarKinds
{
    public const EVENTS = 'events';
    public const TODOS = 'todos';

    public static function values(): array
    {
        return [self::EVENTS, self::TODOS];
    }
}
