<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Requests;

use Rudashi\GusApi\Contracts\Request;
use Rudashi\GusApi\Enums\GetValue;
use Rudashi\GusApi\Enums\RequestParameter;

class GetValueRequest implements Request
{
    public function __construct(
        private readonly GetValue $parameter,
    ) {
    }

    public function toArray(): array
    {
        return [
            RequestParameter::PARAM_NAME->value => $this->parameter->value,
        ];
    }
}
