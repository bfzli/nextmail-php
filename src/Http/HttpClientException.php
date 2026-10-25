<?php

declare(strict_types=1);

namespace Nextmail\Http;

use Nextmail\Exception\NextmailException;

final class HttpClientException extends \RuntimeException implements NextmailException
{
    public function __construct(string $message, private readonly bool $timeout = false, ?\Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    public function isTimeout(): bool
    {
        return $this->timeout;
    }
}
