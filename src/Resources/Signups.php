<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;

final class Signups extends Resource
{
    public function create(#[\SensitiveParameter] array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::SIGNUPS, 'POST', body: $body, anonymous: true);
    }

    public function verify(string $signUpId, #[\SensitiveParameter] string $code, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SIGNUP_VERIFY, id: $signUpId), 'POST', body: ['code' => $code], anonymous: true);
    }
}
