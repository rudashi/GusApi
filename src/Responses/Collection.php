<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Responses;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Rudashi\GusApi\Contracts\Response;
use Traversable;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @implements \IteratorAggregate<TKey, TValue>
 */
class Collection implements Countable, IteratorAggregate, Response
{
    /**
     * @param array<TKey, TValue> $items
     */
    public function __construct(
        public array $items
    ) {
    }

    /**
     * @param callable(string|\SimpleXMLElement): mixed $callable
     * @param iterable<\SimpleXMLElement> $items
     *
     * @return self<TKey, TValue>
     */
    public static function each(callable $callable, iterable $items): self
    {
        return new self(array_map($callable, $items));
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function first(): mixed
    {
        return $this->items[0] ?? null;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @return array<TKey, TValue>
     */
    public function result(): array
    {
        return $this->items;
    }
}
