<?php

declare(strict_types=1);

namespace Nextmail\Internal;

final class WireShapes
{
    public const OBJECT_KEYS = [
        'abTest' => true,
        'appearance' => true,
        'args' => true,
        'attributes' => true,
        'availability' => true,
        'busy' => true,
        'condition' => true,
        'config' => true,
        'copy' => true,
        'definition' => true,
        'document' => true,
        'encryption' => true,
        'guestChanges' => true,
        'headers' => true,
        'input' => true,
        'loginBackground' => true,
        'mail' => true,
        'nameParts' => true,
        'properties' => true,
        'receiving' => true,
        'reply' => true,
        'rules' => true,
        'schedule' => true,
        'send' => true,
        'sendWindow' => true,
        'sending' => true,
        'seo' => true,
        'settings' => true,
        'style' => true,
        'tags' => true,
        'timeout' => true,
        'tracking' => true,
        'translate' => true,
        'trigger' => true,
        'utm' => true,
        'values' => true,
        'wait' => true,
        'webFont' => true,
    ];
    public const OBJECT_PATHS = [
        '.data' => true,
        '.fonts' => true,
        '.options' => true,
        'appearance.fonts' => true,
        'config.location' => true,
        'config.reminders' => true,
        'steps.from' => true,
        'steps.props' => true,
        'steps.value' => true,
        'template.props' => true,
        'template.slots' => true,
        'values.props' => true,
        'values.slots' => true,
    ];
}
