<?php

declare(strict_types=1);

namespace Nextmail\Resources;

use Nextmail\Internal\LiveEventStream;
use Nextmail\Internal\Protocol;
use Nextmail\Transport;

final class LiveEvents extends Resource
{
    private readonly array $timing;

    public function __construct(Transport $transport, array $timing = [])
    {
        parent::__construct($transport);

        $this->timing = [...Protocol::LIVE_STREAM_TIMING, ...$timing];
    }

    public function stream(
        string|array|null $types = null,
        ?string $address = null,
        ?string $lastEventId = null,
        #[\SensitiveParameter]
        ?string $apiKey = null,
    ): \Generator {
        return LiveEventStream::events(
            $this->transport,
            $this->query(types: $this->joined($types), address: $address),
            $lastEventId,
            $apiKey,
            $this->timing,
        );
    }
}
