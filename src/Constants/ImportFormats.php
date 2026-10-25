<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class ImportFormats
{
    public const GMAIL = 'gmail';
    public const PLATFORM = 'platform';
    public const THUNDERBIRD = 'thunderbird';
    public const PROTON = 'proton';
    public const MBOX = 'mbox';
    public const EML = 'eml';
    public const IMAP = 'imap';
    public const MICROSOFT = 'microsoft';

    public static function values(): array
    {
        return [
            self::GMAIL,
            self::PLATFORM,
            self::THUNDERBIRD,
            self::PROTON,
            self::MBOX,
            self::EML,
            self::IMAP,
            self::MICROSOFT,
        ];
    }
}
