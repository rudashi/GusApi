<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Responses;

use Rudashi\GusApi\Contracts\Response;

class LogoutResponse implements Response
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
