<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Result\Page;

final class Tasks extends Resource
{
    public function list(?string $status = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage(ApiPaths::TASKS, $this->query(status: $status), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAll(?string $status = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll(ApiPaths::TASKS, $this->query(status: $status), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterate(?string $status = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages(ApiPaths::TASKS, $this->query(status: $status), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function get(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::TASK, id: $id), apiKey: $apiKey);
    }

    public function create(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::TASKS, 'POST', body: $body, apiKey: $apiKey);
    }

    public function update(string $id, array $patch, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::TASK, id: $id), 'PATCH', body: $patch, repeatable: true, apiKey: $apiKey);
    }

    public function delete(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::TASK, id: $id), 'DELETE', apiKey: $apiKey);
    }

    public function pause(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::TASK_PAUSE, id: $id), 'POST', repeatable: true, apiKey: $apiKey);
    }

    public function resume(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::TASK_RESUME, id: $id), 'POST', repeatable: true, apiKey: $apiKey);
    }

    public function run(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::TASK_RUN_NOW, id: $id), 'POST', apiKey: $apiKey);
    }

    public function listRuns(
        ?string $taskId = null,
        ?string $status = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage(ApiPaths::TASK_RUNS, $this->query(taskId: $taskId, status: $status), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllRuns(
        ?string $taskId = null,
        ?string $status = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll(ApiPaths::TASK_RUNS, $this->query(taskId: $taskId, status: $status), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateRuns(
        ?string $taskId = null,
        ?string $status = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages(ApiPaths::TASK_RUNS, $this->query(taskId: $taskId, status: $status), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function getRun(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::TASK_RUN, id: $id), apiKey: $apiKey);
    }

    public function startRun(array $body, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call(ApiPaths::TASK_RUNS, 'POST', body: $body, apiKey: $apiKey);
    }

    public function cancelRun(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::TASK_RUN_CANCEL, id: $id), 'POST', apiKey: $apiKey);
    }

    public function listApprovals(
        ?string $status = null,
        ?string $runId = null,
        ?string $taskId = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage(ApiPaths::TASK_APPROVALS, $this->query(status: $status, runId: $runId, taskId: $taskId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllApprovals(
        ?string $status = null,
        ?string $runId = null,
        ?string $taskId = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll(ApiPaths::TASK_APPROVALS, $this->query(status: $status, runId: $runId, taskId: $taskId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateApprovals(
        ?string $status = null,
        ?string $runId = null,
        ?string $taskId = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages(ApiPaths::TASK_APPROVALS, $this->query(status: $status, runId: $runId, taskId: $taskId), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function getApproval(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::TASK_APPROVAL, id: $id), apiKey: $apiKey);
    }

    public function approve(string $id, ?array $body = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::TASK_APPROVAL_APPROVE, id: $id), 'POST', body: $this->payload($body), apiKey: $apiKey);
    }

    public function deny(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::TASK_APPROVAL_DENY, id: $id), 'POST', apiKey: $apiKey);
    }
}
