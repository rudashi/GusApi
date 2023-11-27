<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Contracts;

interface SoapCall
{
    public function functionName(): string;

    public function headers(): array;
}
