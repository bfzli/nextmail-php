<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Internal\Pagination;
use Nextmail\Result\Page;

final class Signatures extends Resource
{
    public function list(?string $address = null, ?string $from = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage(ApiPaths::SIGNATURES, $this->query(address: $address, from: $from), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAll(?string $address = null, ?string $from = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll(ApiPaths::SIGNATURES, $this->query(address: $address, from: $from), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterate(?string $address = null, ?string $from = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages(ApiPaths::SIGNATURES, $this->query(address: $address, from: $from), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function get(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SIGNATURE, id: $id), apiKey: $apiKey);
    }

    public function create(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::SIGNATURES, 'POST', body: $body, apiKey: $apiKey);
    }

    public function update(string $id, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SIGNATURE, id: $id), 'PATCH', body: $patch, repeatable: true, apiKey: $apiKey);
    }

    public function delete(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::SIGNATURE, id: $id), 'DELETE', apiKey: $apiKey);
    }

    public function copy(string $id, array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        $envelope = $this->call($this->fill(ApiPaths::SIGNATURE_COPY, id: $id), 'POST', body: $body, repeatable: true, apiKey: $apiKey);

        return Pagination::itemsOf($envelope);
    }
}
