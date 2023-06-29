<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Environment;

class Development implements EnvironmentInterface
{
    public function serviceUrl(): string
    {
        return 'https://wyszukiwarkaregontest.stat.gov.pl/wsBIR/UslugaBIRzewnPubl.svc';
    }

    public function wsdlUrl(): string
    {
        return 'https://wyszukiwarkaregontest.stat.gov.pl/wsBIR/wsdl/UslugaBIRzewnPubl-ver11-test.wsdl';
    }
}
