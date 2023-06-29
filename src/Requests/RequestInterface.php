<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Requests;

interface RequestInterface
{
    public function toArray(): array;
}
