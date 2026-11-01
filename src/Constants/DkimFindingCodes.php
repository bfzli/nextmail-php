<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class DkimFindingCodes
{
    public const LOOKUP_FAILED = 'lookup-failed';
    public const NOT_FOUND = 'not-found';
    public const NONE_FOUND = 'none-found';
    public const NOT_DKIM = 'not-dkim';
    public const ALIASED = 'aliased';
    public const MULTIPLE_RECORDS = 'multiple-records';
    public const VERSION_INVALID = 'version-invalid';
    public const VERSION_NOT_FIRST = 'version-not-first';
    public const DUPLICATE_TAG = 'duplicate-tag';
    public const MALFORMED_TAG = 'malformed-tag';
    public const MISSING_KEY = 'missing-key';
    public const INVALID_KEY = 'invalid-key';
    public const REVOKED = 'revoked';
    public const WEAK_KEY = 'weak-key';
    public const SHORT_KEY = 'short-key';
    public const STRONG_KEY = 'strong-key';
    public const LONG_KEY = 'long-key';
    public const ED25519_KEY = 'ed25519-key';
    public const UNKNOWN_KEY_TYPE = 'unknown-key-type';
    public const SHA1_ONLY = 'sha1-only';
    public const SHA1_ALLOWED = 'sha1-allowed';
    public const UNKNOWN_HASH = 'unknown-hash';
    public const TESTING_MODE = 'testing-mode';
    public const STRICT_MODE = 'strict-mode';
    public const SERVICE_MISMATCH = 'service-mismatch';
    public const OBSOLETE_GRANULARITY = 'obsolete-granularity';
    public const UNKNOWN_TAG = 'unknown-tag';

    public static function values(): array
    {
        return [
            self::LOOKUP_FAILED,
            self::NOT_FOUND,
            self::NONE_FOUND,
            self::NOT_DKIM,
            self::ALIASED,
            self::MULTIPLE_RECORDS,
            self::VERSION_INVALID,
            self::VERSION_NOT_FIRST,
            self::DUPLICATE_TAG,
            self::MALFORMED_TAG,
            self::MISSING_KEY,
            self::INVALID_KEY,
            self::REVOKED,
            self::WEAK_KEY,
            self::SHORT_KEY,
            self::STRONG_KEY,
            self::LONG_KEY,
            self::ED25519_KEY,
            self::UNKNOWN_KEY_TYPE,
            self::SHA1_ONLY,
            self::SHA1_ALLOWED,
            self::UNKNOWN_HASH,
            self::TESTING_MODE,
            self::STRICT_MODE,
            self::SERVICE_MISMATCH,
            self::OBSOLETE_GRANULARITY,
            self::UNKNOWN_TAG,
        ];
    }
}
