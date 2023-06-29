<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Responses;

use ArrayIterator;
use Closure;
use Countable;
use IteratorAggregate;
use Traversable;

class Collection implements Countable, IteratorAggregate, ResponseInterface
{
    public function __construct(
        public array $items
    ) {
    }

    public static function each(Closure $callable, array $items): static
    {
        return new static(array_map($callable, $items));
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

    public function result(): array
    {
        return $this->items;
    }
}
