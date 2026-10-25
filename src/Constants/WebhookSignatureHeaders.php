<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class WebhookSignatureHeaders
{
    public const SIGNATURE = 'X-Webhook-Signature';
    public const EVENT = 'X-Webhook-Event';
    public const DELIVERY = 'X-Webhook-Delivery';

    public static function values(): array
    {
        return [self::SIGNATURE, self::EVENT, self::DELIVERY];
    }
}
