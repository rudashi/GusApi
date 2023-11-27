<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Contracts;

interface Request
{
    public function toArray(): array;
}
