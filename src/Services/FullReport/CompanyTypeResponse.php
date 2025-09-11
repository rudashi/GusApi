<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\FullReport;

use Rudashi\GusApi\Contracts\Response;
use Rudashi\GusApi\Enums\CompanyType;

readonly class CompanyTypeResponse implements Response
{
    public function __construct(
        private CompanyType $type,
    ) {
    }

    public function result(): CompanyType
    {
        return $this->type;
    }

    public static function of(string $value): self
    {
        return new self(
            CompanyType::from($value)
        );
    }
}
