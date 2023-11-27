<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Contracts;

interface Environment
{
    public function serviceUrl(): string;

    public function wsdlUrl(): string;
}
