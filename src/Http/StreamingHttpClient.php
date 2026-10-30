<?php

declare(strict_types=1);

namespace Nextmail\Http;

interface StreamingHttpClient extends HttpClient
{
    public function stream(HttpRequest $request): HttpStream;
}
