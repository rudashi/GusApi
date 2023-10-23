<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\FullReport;

use Rudashi\GusApi\Enums\CompanyType;
use Rudashi\GusApi\Responses\ResponseInterface;

/**
 * @phpstan-consistent-constructor
 */
class CompanyTypeResponse implements ResponseInterface
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
