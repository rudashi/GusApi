<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Requests;

use Rudashi\GusApi\Contracts\Request;
use Rudashi\GusApi\Enums\RequestParameter;
use Rudashi\GusApi\Services\SearchParameters;

class SearchDataRequest implements Request
{
    public function __construct(
        private readonly SearchParameters $parameter,
    ) {
    }

    public function toArray(): array
    {
        return [
            RequestParameter::SEARCH->value => $this->parameter->toArray(),
        ];
    }
}
