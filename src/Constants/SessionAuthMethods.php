<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class SessionAuthMethods
{
    public const PASSWORD = 'password';
    public const TOTP = 'totp';
    public const BACKUP_CODE = 'backup-code';
    public const PASSKEY = 'passkey';
    public const EMAIL_LINK = 'email-link';
    public const HANDOFF = 'handoff';

    public static function values(): array
    {
        return [self::PASSWORD, self::TOTP, self::BACKUP_CODE, self::PASSKEY, self::EMAIL_LINK, self::HANDOFF];
    }
}
