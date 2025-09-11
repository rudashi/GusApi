<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Contracts;

interface Response
{
    public function result(): mixed;
}
