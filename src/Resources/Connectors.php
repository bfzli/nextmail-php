<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Result\Page;

final class Connectors extends Resource
{
    public function listApps(
        ?string $search = null,
        ?string $category = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage(ApiPaths::CONNECTOR_APPS, $this->query(search: $search, category: $category), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllApps(
        ?string $search = null,
        ?string $category = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll(ApiPaths::CONNECTOR_APPS, $this->query(search: $search, category: $category), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateApps(
        ?string $search = null,
        ?string $category = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages(ApiPaths::CONNECTOR_APPS, $this->query(search: $search, category: $category), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function getApp(string $slug, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONNECTOR_APP, slug: $slug), apiKey: $apiKey);
    }

    public function listCategories(#[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList(ApiPaths::CONNECTOR_CATEGORIES, apiKey: $apiKey);
    }

    public function list(?string $scope = null, ?string $status = null, ?string $app = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList(ApiPaths::CONNECTORS, $this->query(scope: $scope, status: $status, app: $app), $apiKey);
    }

    public function get(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONNECTOR, id: $id), apiKey: $apiKey);
    }

    public function connect(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::CONNECTORS, 'POST', body: $body, apiKey: $apiKey);
    }

    public function update(string $id, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONNECTOR, id: $id), 'PATCH', body: $patch, apiKey: $apiKey);
    }

    public function disconnect(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONNECTOR, id: $id), 'DELETE', repeatable: true, apiKey: $apiKey);
    }

    public function reconnect(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONNECTOR_RECONNECT, id: $id), 'POST', apiKey: $apiKey);
    }

    public function listActions(string $id, ?string $search = null, ?int $limit = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->fetchList($this->fill(ApiPaths::CONNECTOR_ACTIONS, id: $id), $this->query(search: $search, limit: $limit), $apiKey);
    }

    public function getAction(string $id, string $action, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONNECTOR_ACTION, id: $id, action: $action), apiKey: $apiKey);
    }

    public function runAction(string $id, string $action, ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::CONNECTOR_ACTION_RUN, id: $id, action: $action), 'POST', body: $this->payload($body), apiKey: $apiKey);
    }

    public function listCalls(
        ?string $connectorId = null,
        ?string $scope = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage(ApiPaths::CONNECTOR_CALLS, $this->query(connectorId: $connectorId, scope: $scope), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllCalls(
        ?string $connectorId = null,
        ?string $scope = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll(ApiPaths::CONNECTOR_CALLS, $this->query(connectorId: $connectorId, scope: $scope), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateCalls(
        ?string $connectorId = null,
        ?string $scope = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages(ApiPaths::CONNECTOR_CALLS, $this->query(connectorId: $connectorId, scope: $scope), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }
}
