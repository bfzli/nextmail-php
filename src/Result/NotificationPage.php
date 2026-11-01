<?php

declare(strict_types=1);

namespace Nextmail\Result;

final class NotificationPage implements \IteratorAggregate, \Countable
{
    public function __construct(
        public readonly array $items,
        public readonly int $unreadCount,
        public readonly bool $hasMore,
        public readonly ?string $nextCursor,
    ) {}

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
        return \count($this->items);
    }
}
