<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services;

use Rudashi\GusApi\Contracts\SoapCall;
use Rudashi\GusApi\Enums\Action;
use SoapHeader;

class FullReport implements SoapCall
{
    public function __construct(
        private readonly Action $action,
    ) {
    }

    public function functionName(): string
    {
        return $this->action->value;
    }

    public function headers(): array
    {
        return [
            new SoapHeader(
                namespace: 'http://www.w3.org/2005/08/addressing',
                name: 'Action',
                data: 'http://CIS/BIR/PUBL/2014/07/IUslugaBIRzewnPubl/' . $this->action->value
            ),
        ];
    }
}
