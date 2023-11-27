<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Responses;

use Rudashi\GusApi\Contracts\Response;

class GetValueResponse implements Response
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
