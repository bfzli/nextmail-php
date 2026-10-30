<?php

declare(strict_types=1);

namespace Nextmail\Internal;

final class EventStreamRecord
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $event,
        public readonly ?string $data,
        public readonly ?int $retry,
    ) {}
}
