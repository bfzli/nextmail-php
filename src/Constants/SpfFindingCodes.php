<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class SpfFindingCodes
{
    public const LOOKUP_FAILED = 'lookup-failed';
    public const DOMAIN_MISSING = 'domain-missing';
    public const NO_RECORD = 'no-record';
    public const NEAR_MISS = 'near-miss';
    public const ONE_RECORD = 'one-record';
    public const MULTIPLE_RECORDS = 'multiple-records';
    public const VALID_SYNTAX = 'valid-syntax';
    public const INVALID_TERM = 'invalid-term';
    public const UNKNOWN_MECHANISM = 'unknown-mechanism';
    public const INVALID_ADDRESS = 'invalid-address';
    public const INVALID_DOMAIN = 'invalid-domain';
    public const LOOKUPS_WITHIN_LIMIT = 'lookups-within-limit';
    public const NEAR_LOOKUP_LIMIT = 'near-lookup-limit';
    public const TOO_MANY_LOOKUPS = 'too-many-lookups';
    public const TOO_MANY_VOID_LOOKUPS = 'too-many-void-lookups';
    public const VOID_LOOKUP = 'void-lookup';
    public const INCLUDE_MISSING = 'include-missing';
    public const INCLUDE_MULTIPLE = 'include-multiple';
    public const INCLUDE_LOOP = 'include-loop';
    public const INCLUDE_LOOKUP_FAILED = 'include-lookup-failed';
    public const TOO_MANY_MX_HOSTS = 'too-many-mx-hosts';
    public const PASS_ALL = 'pass-all';
    public const NEUTRAL_ALL = 'neutral-all';
    public const SOFTFAIL_ALL = 'softfail-all';
    public const FAIL_ALL = 'fail-all';
    public const NO_ALL = 'no-all';
    public const TERMS_AFTER_ALL = 'terms-after-all';
    public const REDIRECT_IGNORED = 'redirect-ignored';
    public const DUPLICATE_MODIFIER = 'duplicate-modifier';
    public const PTR_USED = 'ptr-used';
    public const MACROS_USED = 'macros-used';
    public const UNKNOWN_MODIFIER = 'unknown-modifier';
    public const BROAD_RANGE = 'broad-range';
    public const LONG_RECORD = 'long-record';
    public const LONG_STRING = 'long-string';
    public const ANALYSIS_TRUNCATED = 'analysis-truncated';

    public static function values(): array
    {
        return [
            self::LOOKUP_FAILED,
            self::DOMAIN_MISSING,
            self::NO_RECORD,
            self::NEAR_MISS,
            self::ONE_RECORD,
            self::MULTIPLE_RECORDS,
            self::VALID_SYNTAX,
            self::INVALID_TERM,
            self::UNKNOWN_MECHANISM,
            self::INVALID_ADDRESS,
            self::INVALID_DOMAIN,
            self::LOOKUPS_WITHIN_LIMIT,
            self::NEAR_LOOKUP_LIMIT,
            self::TOO_MANY_LOOKUPS,
            self::TOO_MANY_VOID_LOOKUPS,
            self::VOID_LOOKUP,
            self::INCLUDE_MISSING,
            self::INCLUDE_MULTIPLE,
            self::INCLUDE_LOOP,
            self::INCLUDE_LOOKUP_FAILED,
            self::TOO_MANY_MX_HOSTS,
            self::PASS_ALL,
            self::NEUTRAL_ALL,
            self::SOFTFAIL_ALL,
            self::FAIL_ALL,
            self::NO_ALL,
            self::TERMS_AFTER_ALL,
            self::REDIRECT_IGNORED,
            self::DUPLICATE_MODIFIER,
            self::PTR_USED,
            self::MACROS_USED,
            self::UNKNOWN_MODIFIER,
            self::BROAD_RANGE,
            self::LONG_RECORD,
            self::LONG_STRING,
            self::ANALYSIS_TRUNCATED,
        ];
    }
}
