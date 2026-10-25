<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;

final class Senders extends Resource
{
    public function get(string $email, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SENDER, email: $email), apiKey: $apiKey);
    }

    public function getAvatar(string $email, #[\SensitiveParameter] ?string $apiKey = null): string
    {
        return $this->bytes($this->fill(ApiPaths::SENDER_AVATAR, email: $email), $apiKey);
    }

    public function research(string $email, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SENDER_RESEARCH, email: $email), 'POST', repeatable: true, apiKey: $apiKey);
    }
}
