<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class AutomationConditionKinds
{
    public const EMAIL_OPENED = 'email_opened';
    public const EMAIL_CLICKED = 'email_clicked';
    public const IN_AUDIENCE = 'in_audience';
    public const FIELD = 'field';
    public const EVENT = 'event';
    public const REPLIED = 'replied';
    public const EMAIL_MATCHES = 'email_matches';
    public const AI_CHECK = 'ai_check';
    public const ADDRESS_CHECK = 'address_check';

    public static function values(): array
    {
        return [
            self::EMAIL_OPENED,
            self::EMAIL_CLICKED,
            self::IN_AUDIENCE,
            self::FIELD,
            self::EVENT,
            self::REPLIED,
            self::EMAIL_MATCHES,
            self::AI_CHECK,
            self::ADDRESS_CHECK,
        ];
    }
}
