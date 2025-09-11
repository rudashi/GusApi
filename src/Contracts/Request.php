<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Contracts;

interface Request
{
    /**
     * @return array<string, string|string[]>
     */
    public function toArray(): array;
}
