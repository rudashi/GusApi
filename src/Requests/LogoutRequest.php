<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Requests;

use Rudashi\GusApi\Enums\RequestParameter;

class LogoutRequest implements RequestInterface
{
    public function __construct(
        private readonly string $sessionId,
    ) {
    }

    public function toArray(): array
    {
        return [
            RequestParameter::SESSION_ID->value => $this->sessionId,
        ];
    }
}
