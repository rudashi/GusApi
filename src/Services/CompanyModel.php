<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services;

use Rudashi\GusApi\Enums\CompanyType;

class CompanyModel
{
    public readonly CompanyType $Typ;

    public function __construct(
        public readonly string $Regon,
        public readonly string $Nip,
        public readonly string $StatusNip,
        public readonly string $Nazwa,
        public readonly string $Wojewodztwo,
        public readonly string $Powiat,
        public readonly string $Gmina,
        public readonly string $Miejscowosc,
        public readonly string $KodPocztowy,
        public readonly string $Ulica,
        public readonly string $NrNieruchomosci,
        public readonly string $NrLokalu,
        string $Typ,
        public readonly string $SilosID,
        public readonly string $DataZakonczeniaDzialalnosci,
        public readonly string $MiejscowoscPoczty,
    ) {
        $this->Typ = CompanyType::from($Typ);
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
