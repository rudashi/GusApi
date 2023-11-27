<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\FullReport;

use Rudashi\GusApi\Contracts\Response;

class CompanyPartnersResponse implements Response
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
