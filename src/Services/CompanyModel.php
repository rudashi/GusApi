<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services;

use Rudashi\GusApi\Enums\CompanyType;

readonly class CompanyModel
{
    public CompanyType $Typ;

    public function __construct(
        public string $Regon,
        public string $Nip,
        public string $StatusNip,
        public string $Nazwa,
        public string $Wojewodztwo,
        public string $Powiat,
        public string $Gmina,
        public string $Miejscowosc,
        public string $KodPocztowy,
        public string $Ulica,
        public string $NrNieruchomosci,
        public string $NrLokalu,
        string $Typ,
        public string $SilosID,
        public string $DataZakonczeniaDzialalnosci,
        public string $MiejscowoscPoczty,
    ) {
        $this->Typ = CompanyType::from($Typ);
    }

    /**
     * @return array<string, string|\Rudashi\GusApi\Enums\CompanyType>
     */
    public function toArray(): array
    {
        return (array) $this;
    }
}
