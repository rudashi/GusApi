<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Environment;

interface EnvironmentInterface
{
    public function serviceUrl(): string;

    public function wsdlUrl(): string;
}
