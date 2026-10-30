<?php

declare(strict_types=1);

namespace Nextmail\Internal;

use Nextmail\Exception\NetworkException;

final class EventStreamParser
{
    private string $pending = '';

    private string $lead = '';

    private bool $started = false;

    private bool $skipLineFeed = false;

    private ?string $id = null;

    private string $event = '';

    private ?string $data = null;

    private ?int $retry = null;

    private bool $touched = false;

    private int $stored = 0;

    public function push(string $chunk): array
    {
        $records = [];
        $text = $this->started ? $chunk : $this->withoutByteOrderMark($chunk);

        if ($text === '') {
            return $records;
        }

        if ($this->skipLineFeed && $text[0] === "\n") {
            $text = substr($text, 1);
        }

        $this->skipLineFeed = false;
        $length = \strlen($text);
        $offset = 0;

        while ($offset < $length) {
            $span = strcspn($text, Defaults::EVENT_STREAM_LINE_ENDS, $offset);
            $end = $offset + $span;

            if ($end >= $length) {
                break;
            }

            $this->line($this->pending . substr($text, $offset, $span), $records);
            $this->pending = '';

            if ($text[$end] === "\r") {
                if ($end + 1 === $length) {
                    $this->skipLineFeed = true;
                } elseif ($text[$end + 1] === "\n") {
                    $end += 1;
                }
            }

            $offset = $end + 1;
        }

        $this->pending .= substr($text, $offset);

        if ($this->stored + \strlen($this->pending) > Defaults::EVENT_STREAM_MAX_BLOCK_BYTES) {
            throw new NetworkException(\sprintf(Messages::EVENT_STREAM_BLOCK, Defaults::EVENT_STREAM_MAX_BLOCK_BYTES));
        }

        return $records;
    }

    private function withoutByteOrderMark(string $chunk): string
    {
        $lead = $this->lead . $chunk;

        if (\strlen($lead) < \strlen(Defaults::BYTE_ORDER_MARK) && str_starts_with(Defaults::BYTE_ORDER_MARK, $lead)) {
            $this->lead = $lead;

            return '';
        }

        $this->lead = '';
        $this->started = true;

        return str_starts_with($lead, Defaults::BYTE_ORDER_MARK) ? substr($lead, \strlen(Defaults::BYTE_ORDER_MARK)) : $lead;
    }

    private function line(string $line, array &$records): void
    {
        if ($line === '') {
            $this->dispatch($records);

            return;
        }

        if ($line[0] === ':') {
            return;
        }

        $colon = strpos($line, ':');

        if ($colon === false) {
            $this->field($line, '');

            return;
        }

        $value = substr($line, $colon + 1);

        $this->field(substr($line, 0, $colon), str_starts_with($value, ' ') ? substr($value, 1) : $value);
    }

    private function field(string $name, string $value): void
    {
        if ($name === Protocol::EVENT_STREAM_FIELDS['EVENT']) {
            $this->event = $value;
        } elseif ($name === Protocol::EVENT_STREAM_FIELDS['DATA']) {
            $this->data = $this->data === null ? $value : $this->data . "\n" . $value;
            $this->stored += \strlen($value);
        } elseif ($name === Protocol::EVENT_STREAM_FIELDS['ID'] && !str_contains($value, "\0")) {
            $this->id = $value;
        } elseif ($name === Protocol::EVENT_STREAM_FIELDS['RETRY'] && preg_match(Defaults::EVENT_STREAM_RETRY_VALUE, $value) === 1) {
            $this->retry = (int) $value;
        } else {
            return;
        }

        $this->touched = true;
    }

    private function dispatch(array &$records): void
    {
        if ($this->touched) {
            $records[] = new EventStreamRecord(
                $this->id,
                $this->event === '' ? Defaults::EVENT_STREAM_DEFAULT_EVENT : $this->event,
                $this->data,
                $this->retry,
            );
        }

        $this->id = null;
        $this->event = '';
        $this->data = null;
        $this->retry = null;
        $this->touched = false;
        $this->stored = 0;
    }
}
