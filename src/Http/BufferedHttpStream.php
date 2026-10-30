<?php

declare(strict_types=1);

namespace Nextmail\Http;

final class BufferedHttpStream implements HttpStream
{
    private readonly HttpResponse $head;

    private ?string $rest;

    public function __construct(HttpResponse $response)
    {
        $this->head = new HttpResponse($response->status, $response->headers, '');
        $this->rest = $response->body === '' ? null : $response->body;
    }

    public function head(): HttpResponse
    {
        return $this->head;
    }

    public function read(float $timeout): ?string
    {
        $chunk = $this->rest;
        $this->rest = null;

        return $chunk;
    }

    public function close(): void
    {
        $this->rest = null;
    }
}
