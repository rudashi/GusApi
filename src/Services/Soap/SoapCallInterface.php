<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\Soap;

interface SoapCallInterface
{
    public function functionName(): string;

    public function headers(): array;
}
