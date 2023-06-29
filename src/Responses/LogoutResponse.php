<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Responses;

class LogoutResponse implements ResponseInterface
{
    public function __construct(
        private readonly bool $WylogujResult
    ) {
    }

    public function result(): bool
    {
        return $this->WylogujResult;
    }
}
