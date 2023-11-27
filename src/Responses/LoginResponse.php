<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Responses;

use Rudashi\GusApi\Contracts\Response;

class LoginResponse implements Response
{
    public function __construct(
        private readonly string $ZalogujResult
    ) {
    }

    public function result(): string
    {
        return $this->ZalogujResult;
    }

    public function isAuthorized(): bool
    {
        return $this->ZalogujResult !== '';
    }
}
