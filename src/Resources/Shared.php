<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;

final class Shared extends Resource
{
    public function get(string $token, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SHARED_ITEM, token: $token), apiKey: $apiKey);
    }

    public function copy(string $token, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SHARED_ITEM_COPY, token: $token), 'POST', apiKey: $apiKey);
    }
}
