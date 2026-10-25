<?php

declare(strict_types=1);

namespace Nextmail\Http;

interface HttpClient
{
    public function send(HttpRequest $request): HttpResponse;
}
