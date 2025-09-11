<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Contracts;

interface SoapCall
{
    public function functionName(): string;

    /**
     * @return \SoapHeader[]
     */
    public function headers(): array;
}
