<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\FullReport;

use Rudashi\GusApi\Contracts\Response;

readonly class CompanyPartnersResponse implements Response
{
    public function __construct(
        public string $wspolsc_regonWspolnikSpolki,
        public string $wspolsc_firmaNazwa = '',
        public string $wspolsc_imiePierwsze = '',
        public string $wspolsc_nazwisko = '',
    ) {
    }

    /**
     * @return array<string, string>
     */
    public function result(): array
    {
        return (array) $this;
    }
}
