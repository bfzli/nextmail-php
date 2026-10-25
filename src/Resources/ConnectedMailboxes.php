<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;

final class ConnectedMailboxes extends Resource
{
    public function list(?string $q = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList(ApiPaths::CONNECTED_MAILBOXES, $this->query(q: $q), apiKey: $apiKey);
    }

    public function get(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONNECTED_MAILBOX, id: $id), apiKey: $apiKey);
    }

    public function discover(string $email, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::CONNECTED_MAILBOX_SETTINGS, query: $this->query(email: $email), apiKey: $apiKey);
    }

    public function connect(#[\SensitiveParameter] array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::CONNECTED_MAILBOXES, 'POST', body: $body, apiKey: $apiKey);
    }

    public function update(string $id, #[\SensitiveParameter] array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONNECTED_MAILBOX, id: $id), 'PATCH', body: $patch, apiKey: $apiKey);
    }

    public function sync(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONNECTED_MAILBOX_SYNC, id: $id), 'POST', repeatable: true, apiKey: $apiKey);
    }

    public function disconnect(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONNECTED_MAILBOX, id: $id), 'DELETE', repeatable: true, apiKey: $apiKey);
    }
}
