<?php

declare(strict_types=1);

namespace Nextmail\Internal;

use Nextmail\Constants\ErrorTypes;
use Nextmail\Constants\LiveEventTypes;
use Nextmail\Constants\LiveResetReasons;
use Nextmail\Exception\ApiException;
use Nextmail\Exception\NetworkException;
use Nextmail\Exception\NextmailException;
use Nextmail\Http\HttpClientException;
use Nextmail\Http\HttpResponse;
use Nextmail\Transport;

final class LiveEventStream
{
    public static function events(
        Transport $transport,
        array $query,
        ?string $lastEventId,
        #[\SensitiveParameter]
        ?string $apiKey,
        array $timing,
    ): \Generator {
        $resumeId = $lastEventId ?? '';
        $retryMs = min(self::timing($timing, 'DEFAULT_RETRY_MS'), self::timing($timing, 'MAX_BACKOFF_MS'));
        $idleSeconds = self::timing($timing, 'IDLE_TIMEOUT_MS') / Defaults::MILLISECONDS_PER_SECOND;
        $failures = 0;
        $delayMs = 0;

        while (true) {
            if ($delayMs > 0) {
                $transport->wait($delayMs / Defaults::MILLISECONDS_PER_SECOND);
            }

            $startedAt = self::nowMs();

            try {
                $stream = $transport->stream(
                    ApiPaths::LIVE_EVENTS,
                    $query,
                    $resumeId === '' ? [] : [Protocol::HEADER_KEYS['LAST_EVENT_ID'] => $resumeId],
                    Protocol::CONTENT_TYPES['EVENT_STREAM'],
                    $apiKey,
                );
            } catch (NetworkException) {
                $delayMs = self::retryDelay($failures, $timing, null);
                $failures += 1;

                continue;
            } catch (ApiException $error) {
                if (!$error->isRetryable() && !$error->isServerError()) {
                    throw $error;
                }

                $delayMs = self::retryDelay($failures, $timing, $error->retryAfterSeconds);
                $failures += 1;

                continue;
            }

            $failed = false;

            try {
                $head = $stream->head();

                if (self::mediaType($head) !== Protocol::CONTENT_TYPES['EVENT_STREAM']) {
                    throw self::notAnEventStream($head);
                }

                $failures = 0;
                $parser = new EventStreamParser();
                $ended = false;

                while (!$ended) {
                    $chunk = null;

                    try {
                        $chunk = $stream->read($idleSeconds);
                        $records = $chunk === null ? [] : $parser->push($chunk);
                    } catch (NextmailException|\LogicException $error) {
                        if (!$error instanceof HttpClientException && !$error instanceof NetworkException) {
                            throw $error;
                        }

                        $chunk = null;
                        $records = [];
                        $failed = true;
                    } catch (\Exception) {
                        $chunk = null;
                        $records = [];
                        $failed = true;
                    }

                    foreach ($records as $record) {
                        if (!$record instanceof EventStreamRecord) {
                            continue;
                        }

                        if ($record->retry !== null) {
                            $retryMs = min($record->retry, self::timing($timing, 'MAX_BACKOFF_MS'));
                        }

                        if ($record->id !== null) {
                            $resumeId = $record->id;
                        }

                        if ($record->data === null) {
                            continue;
                        }

                        if ($record->event === Protocol::LIVE_STREAM_EVENTS['END']) {
                            $ended = true;

                            break;
                        }

                        $event = self::eventOf($record, $resumeId);

                        if ($event !== null) {
                            yield $event;
                        }
                    }

                    if ($chunk === null) {
                        $ended = true;
                    }
                }
            } finally {
                $stream->close();
            }

            $delayMs = $failed ? self::retryDelay($failures, $timing, null) : max(0, (int) ceil($startedAt + $retryMs - self::nowMs()));
            $failures = $failed ? $failures + 1 : 0;
        }
    }

    private static function eventOf(EventStreamRecord $record, string $resumeId): ?array
    {
        if ($record->data === null) {
            return null;
        }

        $payload = self::payload($record->data);

        if ($record->event === Protocol::LIVE_STREAM_EVENTS['RESET']) {
            $reason = $payload['reason'] ?? null;

            return [
                'id' => $resumeId,
                'type' => Protocol::LIVE_STREAM_EVENTS['RESET'],
                'occurredAt' => Wire::instant(new \DateTimeImmutable()),
                'data' => ['reason' => \is_string($reason) ? $reason : LiveResetReasons::UNKNOWN],
            ];
        }

        if ($payload === null || !\in_array($record->event, LiveEventTypes::values(), true)) {
            return null;
        }

        return $payload;
    }

    private static function payload(string $data): ?array
    {
        if (!str_starts_with(ltrim($data, Defaults::JSON_WHITESPACE), '{')) {
            return null;
        }

        try {
            $decoded = Json::decode($data);
        } catch (\JsonException) {
            return null;
        }

        return \is_array($decoded) ? $decoded : null;
    }

    private static function mediaType(HttpResponse $head): string
    {
        $type = explode(Protocol::MEDIA_TYPE_PARAMETER_SEPARATOR, $head->header(Protocol::HEADER_KEYS['CONTENT_TYPE']) ?? '', 2)[0];

        return strtolower(trim($type));
    }

    private static function notAnEventStream(HttpResponse $head): ApiException
    {
        $type = self::mediaType($head);

        return ApiException::create(
            \sprintf(Messages::NOT_AN_EVENT_STREAM, $head->status, $type === '' ? Messages::NO_CONTENT_TYPE : $type),
            $head->status,
            ErrorTypes::API_ERROR,
            Protocol::ERROR_CODES['UNRECOGNISED_RESPONSE'],
            requestId: $head->header(Protocol::HEADER_KEYS['REQUEST_ID']),
        );
    }

    private static function retryDelay(int $failures, array $timing, int|float|null $retryAfterSeconds): int
    {
        $limit = min(self::timing($timing, 'MAX_BACKOFF_MS'), self::timing($timing, 'BASE_BACKOFF_MS') * (2 ** min($failures, 30)));
        $jitter = 0.5 + (random_int(0, Defaults::MICROSECONDS_PER_SECOND) / Defaults::MICROSECONDS_PER_SECOND) * 0.5;
        $backoff = (int) round($limit * $jitter);

        if ($retryAfterSeconds === null) {
            return $backoff;
        }

        return max($backoff, (int) min($retryAfterSeconds * Defaults::MILLISECONDS_PER_SECOND, self::timing($timing, 'MAX_RETRY_AFTER_MS')));
    }

    private static function timing(array $timing, string $name): int
    {
        $value = $timing[$name] ?? null;

        return \is_int($value) ? max(0, $value) : 0;
    }

    private static function nowMs(): float
    {
        return microtime(true) * Defaults::MILLISECONDS_PER_SECOND;
    }
}
