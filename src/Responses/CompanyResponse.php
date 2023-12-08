<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Responses;

use Rudashi\GusApi\Contracts\Response;
use Rudashi\GusApi\Services\CompanyModel;

class CompanyResponse implements Response
{
    public function __construct(
        private readonly CompanyModel $company
    ) {
    }

    public function result(): array
    {
        return $this->company->toArray();
    }
}
