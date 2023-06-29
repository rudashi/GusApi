<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Responses;

use Rudashi\GusApi\Services\CompanyModel;

class CompanyResponse implements ResponseInterface
{
    public function __construct(
        private readonly CompanyModel $company
    ) {
    }

    public function result(): array
    {
        return (array) $this->company;
    }
}