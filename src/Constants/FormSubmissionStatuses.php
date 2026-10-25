<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class FormSubmissionStatuses
{
    public const PENDING = 'pending';
    public const ADDED = 'added';

    public static function values(): array
    {
        return [self::PENDING, self::ADDED];
    }
}
