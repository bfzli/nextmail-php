<?php

declare(strict_types=1);

namespace Nextmail\Constants;

final class NotificationKinds
{
    public const WORKSPACE_INVITATION = 'workspace-invitation';

    public static function values(): array
    {
        return [self::WORKSPACE_INVITATION];
    }
}
