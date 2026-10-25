<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;
use Nextmail\Result\Page;

final class Tracking extends Resource
{
    public function list(
        ?bool $opened = null,
        ?bool $clicked = null,
        ?int $days = null,
        ?int $minutes = null,
        ?string $grain = null,
        ?int $offsetMinutes = null,
        ?string $address = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): Page {
        return $this->fetchPage(ApiPaths::TRACKING, $this->listQuery($opened, $clicked, $days, $minutes, $grain, $offsetMinutes, $address), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAll(
        ?bool $opened = null,
        ?bool $clicked = null,
        ?int $days = null,
        ?int $minutes = null,
        ?string $grain = null,
        ?int $offsetMinutes = null,
        ?string $address = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->collectAll(ApiPaths::TRACKING, $this->listQuery($opened, $clicked, $days, $minutes, $grain, $offsetMinutes, $address), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterate(
        ?bool $opened = null,
        ?bool $clicked = null,
        ?int $days = null,
        ?int $minutes = null,
        ?string $grain = null,
        ?int $offsetMinutes = null,
        ?string $address = null,
        ?int $limit = null,
        ?string $cursor = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return $this->iteratePages(ApiPaths::TRACKING, $this->listQuery($opened, $clicked, $days, $minutes, $grain, $offsetMinutes, $address), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function getStats(
        ?int $days = null,
        ?int $minutes = null,
        ?string $grain = null,
        ?int $offsetMinutes = null,
        ?string $address = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        return $this->call(ApiPaths::TRACKING_STATS, query: $this->query(days: $days, minutes: $minutes, grain: $grain, offsetMinutes: $offsetMinutes, address: $address), apiKey: $apiKey);
    }

    public function get(string $id, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->call($this->fill(ApiPaths::TRACKED, id: $id), apiKey: $apiKey);
    }

    public function listOpens(string $id, ?bool $includeMachine = null, ?string $address = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage($this->fill(ApiPaths::TRACKED_OPENS, id: $id), $this->hitQuery($includeMachine, $address), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllOpens(string $id, ?bool $includeMachine = null, ?string $address = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll($this->fill(ApiPaths::TRACKED_OPENS, id: $id), $this->hitQuery($includeMachine, $address), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateOpens(string $id, ?bool $includeMachine = null, ?string $address = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages($this->fill(ApiPaths::TRACKED_OPENS, id: $id), $this->hitQuery($includeMachine, $address), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listClicks(string $id, ?bool $includeMachine = null, ?string $address = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): Page
    {
        return $this->fetchPage($this->fill(ApiPaths::TRACKED_CLICKS, id: $id), $this->hitQuery($includeMachine, $address), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function listAllClicks(string $id, ?bool $includeMachine = null, ?string $address = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): array
    {
        return $this->collectAll($this->fill(ApiPaths::TRACKED_CLICKS, id: $id), $this->hitQuery($includeMachine, $address), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    public function iterateClicks(string $id, ?bool $includeMachine = null, ?string $address = null, ?int $limit = null, ?string $cursor = null, #[\SensitiveParameter] ?string $apiKey = null): \Generator
    {
        return $this->iteratePages($this->fill(ApiPaths::TRACKED_CLICKS, id: $id), $this->hitQuery($includeMachine, $address), limit: $limit, cursor: $cursor, apiKey: $apiKey);
    }

    private function listQuery(?bool $opened, ?bool $clicked, ?int $days, ?int $minutes, ?string $grain, ?int $offsetMinutes, ?string $address): array
    {
        return $this->query(
            opened: $this->flag($opened),
            clicked: $this->flag($clicked),
            days: $days,
            minutes: $minutes,
            grain: $grain,
            offsetMinutes: $offsetMinutes,
            address: $address,
        );
    }

    private function hitQuery(?bool $includeMachine, ?string $address): array
    {
        return $this->query(includeMachine: $this->flag($includeMachine), address: $address);
    }
}
