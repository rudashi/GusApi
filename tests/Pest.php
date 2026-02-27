<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Tests;

use Rudashi\GusApi\Client;
use Rudashi\GusApi\Enums\Environment;
use Rudashi\GusApi\GusApi;

const DEFAULT_KEY = 'abcde12345abcde12345';

function client(): Client
{
    return Client::create(Environment::DEV->service());
}

function api(string $key = DEFAULT_KEY): GusApi
{
    return new GusApi($key);
}
