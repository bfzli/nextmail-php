<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Internal\Wire;
use Nextmail\Result\Page;

final class Chats extends Resource
{
    public function list(?string $q = null, ?string $sort = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage(ApiPaths::CHATS, $this->query(q: $q, sort: $sort), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAll(?string $q = null, ?string $sort = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll(ApiPaths::CHATS, $this->query(q: $q, sort: $sort), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterate(?string $q = null, ?string $sort = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages(ApiPaths::CHATS, $this->query(q: $q, sort: $sort), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function get(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CHAT, id: $id), apiKey: $apiKey);
    }

    public function rename(string $id, string $title, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CHAT, id: $id), 'PATCH', body: ['title' => $title], repeatable: true, apiKey: $apiKey);
    }

    public function delete(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CHAT, id: $id), 'DELETE', apiKey: $apiKey);
    }

    public function listMessages(string $id, ?string $order = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage($this->fill(ApiPaths::CHAT_MESSAGES, id: $id), $this->query(order: $order), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllMessages(string $id, ?string $order = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll($this->fill(ApiPaths::CHAT_MESSAGES, id: $id), $this->query(order: $order), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateMessages(string $id, ?string $order = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages($this->fill(ApiPaths::CHAT_MESSAGES, id: $id), $this->query(order: $order), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function sendMessage(string $id, array $body, int|float|null $timeout = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            $this->fill(ApiPaths::CHAT_MESSAGES, id: $id),
            'POST',
            body: Wire::attachments($body),
            timeout: $timeout ?? $this->turnTimeout(),
            apiKey: $apiKey,
        );
    }

    public function stopTurn(string $id, ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CHAT_STOP, id: $id), 'POST', body: $this->payload($body), apiKey: $apiKey);
    }

    public function approveToolCall(string $id, string $toolCallId, ?array $body = null, int|float|null $timeout = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            $this->fill(ApiPaths::CHAT_TOOL_CALL_APPROVE, id: $id, toolCallId: $toolCallId),
            'POST',
            body: $this->payload($body),
            timeout: $timeout ?? $this->turnTimeout(),
            apiKey: $apiKey,
        );
    }

    public function denyToolCall(string $id, string $toolCallId, int|float|null $timeout = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(
            $this->fill(ApiPaths::CHAT_TOOL_CALL_DENY, id: $id, toolCallId: $toolCallId),
            'POST',
            timeout: $timeout ?? $this->turnTimeout(),
            apiKey: $apiKey,
        );
    }
}
