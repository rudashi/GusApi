<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Enums;

use Rudashi\GusApi\Contracts\Environment as EnvironmentContract;
use Rudashi\GusApi\Environment\Development;
use Rudashi\GusApi\Environment\Production;

enum Environment: string
{
    case DEV = 'dev';
    case PROD = 'prod';

    public function service(): EnvironmentContract
    {
        return match ($this) {
            self::DEV => new Development(),
            self::PROD => new Production(),
        };
    }
}
