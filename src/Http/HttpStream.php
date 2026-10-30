<?php

declare(strict_types=1);

namespace Nextmail\Http;

interface HttpStream
{
    public function head(): HttpResponse;

    public function read(float $timeout): ?string;

    public function close(): void;
}
