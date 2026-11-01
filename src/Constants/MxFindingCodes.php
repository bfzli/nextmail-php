<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class MxFindingCodes
{
    public const LOOKUP_FAILED = 'lookup-failed';
    public const DOMAIN_MISSING = 'domain-missing';
    public const NO_MAIL = 'no-mail';
    public const IMPLICIT_MX = 'implicit-mx';
    public const NULL_MX = 'null-mx';
    public const NULL_MX_MIXED = 'null-mx-mixed';
    public const ADDRESS_TARGET = 'address-target';
    public const ALIAS_TARGET = 'alias-target';
    public const HOST_UNRESOLVED = 'host-unresolved';
    public const RESERVED_ADDRESS = 'reserved-address';
    public const NO_REVERSE_DNS = 'no-reverse-dns';
    public const DUPLICATE_HOST = 'duplicate-host';
    public const SINGLE_HOST = 'single-host';
    public const BACKUP_HOSTS = 'backup-hosts';
    public const LOAD_BALANCED = 'load-balanced';
    public const ALL_RESOLVE = 'all-resolve';
    public const IPV6_READY = 'ipv6-ready';
    public const NO_IPV6 = 'no-ipv6';
    public const PROVIDER = 'provider';

    public static function values(): array
    {
        return [
            self::LOOKUP_FAILED,
            self::DOMAIN_MISSING,
            self::NO_MAIL,
            self::IMPLICIT_MX,
            self::NULL_MX,
            self::NULL_MX_MIXED,
            self::ADDRESS_TARGET,
            self::ALIAS_TARGET,
            self::HOST_UNRESOLVED,
            self::RESERVED_ADDRESS,
            self::NO_REVERSE_DNS,
            self::DUPLICATE_HOST,
            self::SINGLE_HOST,
            self::BACKUP_HOSTS,
            self::LOAD_BALANCED,
            self::ALL_RESOLVE,
            self::IPV6_READY,
            self::NO_IPV6,
            self::PROVIDER,
        ];
    }
}
