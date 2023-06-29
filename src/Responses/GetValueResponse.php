<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Responses;

class GetValueResponse implements ResponseInterface
{
    public function __construct(
        private readonly string $GetValueResult
    ) {
    }

    public function result(): string
    {
        return $this->GetValueResult;
    }
}
