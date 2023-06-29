<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Environment;

class Production implements EnvironmentInterface
{
    public function serviceUrl(): string
    {
        return 'https://wyszukiwarkaregon.stat.gov.pl/wsBIR/UslugaBIRzewnPubl.svc';
    }

    public function wsdlUrl(): string
    {
        return 'https://wyszukiwarkaregon.stat.gov.pl/wsBIR/wsdl/UslugaBIRzewnPubl-ver11-prod.wsdl';
    }
}
