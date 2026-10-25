<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\ApiPaths;

final class Analytics extends Resource
{
    public function mailbox(
        string|\DateTimeInterface|null $from = null,
        string|\DateTimeInterface|null $to = null,
        ?int $offsetMinutes = null,
        ?string $grain = null,
        ?string $address = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        $query = $this->query(from: $this->instant($from), to: $this->instant($to), offsetMinutes: $offsetMinutes, grain: $grain, address: $address);

        return $this->call(ApiPaths::ANALYTICS_MAILBOX, query: $query, apiKey: $apiKey);
    }

    public function sending(
        ?int $days = null,
        ?int $minutes = null,
        ?int $offsetMinutes = null,
        ?string $grain = null,
        ?string $address = null,
        string|\DateTimeInterface|null $since = null,
        string|\DateTimeInterface|null $until = null,
        ?string $recipient = null,
        ?string $tag = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): array {
        $query = $this->query(
            days: $days,
            minutes: $minutes,
            offsetMinutes: $offsetMinutes,
            grain: $grain,
            address: $address,
            since: $this->instant($since),
            until: $this->instant($until),
            recipient: $recipient,
            tag: $tag,
        );

        return $this->call(ApiPaths::ANALYTICS_SENDING, query: $query, apiKey: $apiKey);
    }
}
