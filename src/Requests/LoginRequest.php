<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Requests;

use Rudashi\GusApi\Enums\RequestParameter;

class LoginRequest implements RequestInterface
{
    public function __construct(
        private readonly string $userKey,
    ) {
    }

    public function toArray(): array
    {
        return [
            RequestParameter::USER_KEY->value => $this->userKey,
        ];
    }
}
