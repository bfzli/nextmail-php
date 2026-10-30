<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class SecurityEventKinds
{
    public const SIGN_IN = 'sign-in';
    public const SESSION_REVOKED = 'session-revoked';
    public const SESSIONS_REVOKED = 'sessions-revoked';
    public const PASSWORD_CHANGED = 'password-changed';
    public const PASSWORD_RESET = 'password-reset';
    public const TWO_FACTOR_ENABLED = 'two-factor-enabled';
    public const TWO_FACTOR_DISABLED = 'two-factor-disabled';
    public const PASSKEY_ADDED = 'passkey-added';
    public const PASSKEY_REMOVED = 'passkey-removed';
    public const MEMBER_ADDED = 'member-added';
    public const MEMBER_REMOVED = 'member-removed';
    public const MEMBER_ROLE_CHANGED = 'member-role-changed';
    public const INVITATION_SENT = 'invitation-sent';
    public const INVITATION_REVOKED = 'invitation-revoked';
    public const ROLE_CREATED = 'role-created';
    public const ROLE_CHANGED = 'role-changed';
    public const ROLE_DELETED = 'role-deleted';
    public const TWO_FACTOR_REQUIREMENT_CHANGED = 'two-factor-requirement-changed';
    public const ADDRESS_PASSWORD_SET = 'address-password-set';
    public const ADDRESS_PASSWORD_REMOVED = 'address-password-removed';
    public const CALENDAR_LOGIN_CREATED = 'calendar-login-created';
    public const CALENDAR_LOGIN_REVOKED = 'calendar-login-revoked';
    public const DIRECTORY_SYNC_CONNECTED = 'directory-sync-connected';
    public const DIRECTORY_SYNC_DISCONNECTED = 'directory-sync-disconnected';
    public const DIRECTORY_SYNC_TOKEN_ROTATED = 'directory-sync-token-rotated';
    public const DIRECTORY_SYNC_CHANGED = 'directory-sync-changed';
    public const CONNECTOR_CONNECTED = 'connector-connected';
    public const CONNECTOR_DISCONNECTED = 'connector-disconnected';
    public const CONNECTOR_CHANGED = 'connector-changed';
    public const OWNERSHIP_OFFERED = 'ownership-offered';
    public const OWNERSHIP_TRANSFERRED = 'ownership-transferred';

    public static function values(): array
    {
        return [
            self::SIGN_IN,
            self::SESSION_REVOKED,
            self::SESSIONS_REVOKED,
            self::PASSWORD_CHANGED,
            self::PASSWORD_RESET,
            self::TWO_FACTOR_ENABLED,
            self::TWO_FACTOR_DISABLED,
            self::PASSKEY_ADDED,
            self::PASSKEY_REMOVED,
            self::MEMBER_ADDED,
            self::MEMBER_REMOVED,
            self::MEMBER_ROLE_CHANGED,
            self::INVITATION_SENT,
            self::INVITATION_REVOKED,
            self::ROLE_CREATED,
            self::ROLE_CHANGED,
            self::ROLE_DELETED,
            self::TWO_FACTOR_REQUIREMENT_CHANGED,
            self::ADDRESS_PASSWORD_SET,
            self::ADDRESS_PASSWORD_REMOVED,
            self::CALENDAR_LOGIN_CREATED,
            self::CALENDAR_LOGIN_REVOKED,
            self::DIRECTORY_SYNC_CONNECTED,
            self::DIRECTORY_SYNC_DISCONNECTED,
            self::DIRECTORY_SYNC_TOKEN_ROTATED,
            self::DIRECTORY_SYNC_CHANGED,
            self::CONNECTOR_CONNECTED,
            self::CONNECTOR_DISCONNECTED,
            self::CONNECTOR_CHANGED,
            self::OWNERSHIP_OFFERED,
            self::OWNERSHIP_TRANSFERRED,
        ];
    }
}
