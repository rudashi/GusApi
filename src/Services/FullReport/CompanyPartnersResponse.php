<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\FullReport;

use Rudashi\GusApi\Responses\ResponseInterface;

class CompanyPartnersResponse implements ResponseInterface
{
    public function __construct(
        public readonly string $wspolsc_regonWspolnikSpolki,
        public readonly string $wspolsc_firmaNazwa,
        public readonly string $wspolsc_imiePierwsze = '',
        public readonly string $wspolsc_nazwisko = '',
    ) {
    }

    public function result(): array
    {
        return (array) $this;
    }
}
