<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\FullReport;

use Rudashi\GusApi\Contracts\Response;
use Rudashi\GusApi\Enums\CompanyType;

/**
 * @phpstan-consistent-constructor
 */
class CompanyTypeResponse implements Response
{
    public function __construct(
        private readonly CompanyType $type,
    ) {
    }

    public function result(): CompanyType
    {
        return $this->type;
    }

    public static function of(string $value): static
    {
        return new static(
            CompanyType::from($value)
        );
    }
}
