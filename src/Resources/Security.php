<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Result\Page;

final class Security extends Resource
{
    public function listEvents(?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage(ApiPaths::SECURITY_EVENTS, limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllEvents(?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll(ApiPaths::SECURITY_EVENTS, limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateEvents(?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages(ApiPaths::SECURITY_EVENTS, limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function stepUpStatus(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::SECURITY_STEP_UP, apiKey: $apiKey);
    }

    public function beginStepUp(?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::SECURITY_STEP_UP, 'POST', body: $this->payload($body), apiKey: $apiKey);
    }

    public function verifyStepUp(#[\SensitiveParameter] array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::SECURITY_STEP_UP_VERIFY, 'POST', body: $body, apiKey: $apiKey);
    }

    public function getPolicy(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::SECURITY_POLICY, apiKey: $apiKey);
    }

    public function updatePolicy(array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::SECURITY_POLICY, 'PATCH', body: $patch, repeatable: true, apiKey: $apiKey);
    }
}
