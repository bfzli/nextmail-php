<?php

declare(strict_types=1);

namespace Nextmail\Http;

use Nextmail\Internal\Defaults;
use Nextmail\Internal\Messages;
use Nextmail\Internal\Wire;

final class CurlHttpStream implements HttpStream
{
    private ?\CurlMultiHandle $multi = null;

    private ?\CurlHandle $handle = null;

    private string $buffer = '';

    private array $headers = [];

    private ?HttpResponse $head = null;

    private bool $done = false;

    private ?HttpClientException $error = null;

    public function __destruct()
    {
        $this->close();
    }

    public function callbacks(): array
    {
        return [
            CURLOPT_HEADERFUNCTION => $this->onHeader(...),
            CURLOPT_WRITEFUNCTION => $this->onBody(...),
        ];
    }

    public function start(\CurlHandle $handle, ?float $timeout): void
    {
        $multi = curl_multi_init();
        $added = curl_multi_add_handle($multi, $handle);

        if ($added !== CURLM_OK) {
            throw new HttpClientException(curl_multi_strerror($added) ?? Messages::UNKNOWN_FAILURE);
        }

        $this->multi = $multi;
        $this->handle = $handle;
        $deadline = $timeout === null ? null : microtime(true) + $timeout;

        while (true) {
            $this->perform();

            if ($this->head !== null) {
                return;
            }

            if ($this->done) {
                $this->finishWithoutHead();

                return;
            }

            $left = $deadline === null ? Defaults::STREAM_SELECT_SECONDS : $deadline - microtime(true);

            if ($left <= 0) {
                $this->close();

                throw new HttpClientException(\sprintf(Messages::TIMED_OUT, Wire::numberText((float) $timeout)), true);
            }

            $this->wait(min($left, Defaults::STREAM_SELECT_SECONDS));
        }
    }

    public function head(): HttpResponse
    {
        return $this->head ?? new HttpResponse(0, $this->headers, '');
    }

    public function read(float $timeout): ?string
    {
        $deadline = $timeout > 0 ? microtime(true) + $timeout : null;

        while (true) {
            if ($this->buffer !== '') {
                $chunk = $this->buffer;
                $this->buffer = '';

                return $chunk;
            }

            if ($this->done || $this->multi === null) {
                if ($this->error !== null) {
                    throw $this->error;
                }

                return null;
            }

            $this->perform();

            if ($this->buffer !== '' || $this->done) {
                continue;
            }

            $left = $deadline === null ? Defaults::STREAM_SELECT_SECONDS : $deadline - microtime(true);

            if ($left <= 0) {
                throw new HttpClientException(\sprintf(Messages::STREAM_IDLE, Wire::numberText($timeout)), true);
            }

            $this->wait(min($left, Defaults::STREAM_SELECT_SECONDS));
        }
    }

    public function close(): void
    {
        if ($this->multi !== null && $this->handle !== null) {
            curl_multi_remove_handle($this->multi, $this->handle);
        }

        $this->multi = null;
        $this->handle = null;
        $this->buffer = '';
    }

    private function finishWithoutHead(): void
    {
        if ($this->error !== null) {
            $error = $this->error;
            $this->close();

            throw $error;
        }

        $status = $this->handle === null ? 0 : curl_getinfo($this->handle, CURLINFO_RESPONSE_CODE);
        $this->head = new HttpResponse($status, $this->headers, '');
    }

    private function perform(): void
    {
        $multi = $this->multi;

        if ($multi === null || $this->done) {
            return;
        }

        $running = 0;

        do {
            $status = curl_multi_exec($multi, $running);
        } while ($status === CURLM_CALL_MULTI_PERFORM);

        if ($status !== CURLM_OK) {
            $this->done = true;
            $this->error = new HttpClientException(curl_multi_strerror($status) ?? Messages::UNKNOWN_FAILURE);

            return;
        }

        while (($info = curl_multi_info_read($multi)) !== false) {
            $result = $info['result'] ?? null;

            if ($info['msg'] === CURLMSG_DONE && $info['handle'] === $this->handle && \is_int($result)) {
                $this->done = true;
                $this->error = $result === CURLE_OK ? null : $this->failure($result);
            }
        }
    }

    private function failure(int $code): HttpClientException
    {
        $reason = $this->handle === null ? '' : curl_error($this->handle);

        return new HttpClientException(
            $reason !== '' ? $reason : (curl_strerror($code) ?? Messages::UNKNOWN_FAILURE),
            $code === CURLE_OPERATION_TIMEDOUT,
        );
    }

    private function wait(float $seconds): void
    {
        $multi = $this->multi;

        if ($multi === null) {
            return;
        }

        if (curl_multi_select($multi, $seconds) === -1) {
            usleep(Defaults::STREAM_SELECT_FALLBACK_MICROSECONDS);
        }
    }

    private function onHeader(\CurlHandle $handle, string $line): int
    {
        if ($this->head !== null) {
            return \strlen($line);
        }

        $text = rtrim($line, "\r\n");

        if (str_starts_with($text, 'HTTP/')) {
            $this->headers = [];
        } elseif ($text === '') {
            $status = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);

            if ($status >= 200) {
                $this->head = new HttpResponse($status, $this->headers, '');
            }
        } else {
            $this->collect($text);
        }

        return \strlen($line);
    }

    private function onBody(\CurlHandle $handle, string $data): int
    {
        if ($this->head === null) {
            $this->head = new HttpResponse(curl_getinfo($handle, CURLINFO_RESPONSE_CODE), $this->headers, '');
        }

        $this->buffer .= $data;

        return \strlen($data);
    }

    private function collect(string $text): void
    {
        $at = strpos($text, ':');

        if ($at === false || $at === 0) {
            return;
        }

        $name = strtolower(trim(substr($text, 0, $at)));
        $value = trim(substr($text, $at + 1));
        $existing = $this->headers[$name] ?? null;
        $this->headers[$name] = \is_string($existing) ? $existing . ', ' . $value : $value;
    }
}
