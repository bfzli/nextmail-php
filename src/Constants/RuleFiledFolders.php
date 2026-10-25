<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class RuleFiledFolders
{
    public const ARCHIVE = 'archive';
    public const SPAM = 'spam';
    public const TRASH = 'trash';

    public static function values(): array
    {
        return [self::ARCHIVE, self::SPAM, self::TRASH];
    }
}
