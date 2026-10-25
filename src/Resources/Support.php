<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;

final class Support extends Resource
{
    public function send(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::SUPPORT, 'POST', body: $body, apiKey: $apiKey);
    }
}
