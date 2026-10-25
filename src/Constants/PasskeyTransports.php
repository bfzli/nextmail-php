<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class PasskeyTransports
{
    public const INTERNAL = 'internal';
    public const HYBRID = 'hybrid';
    public const USB = 'usb';
    public const NFC = 'nfc';
    public const BLE = 'ble';
    public const SMART_CARD = 'smart-card';
    public const CABLE = 'cable';

    public static function values(): array
    {
        return [self::INTERNAL, self::HYBRID, self::USB, self::NFC, self::BLE, self::SMART_CARD, self::CABLE];
    }
}
