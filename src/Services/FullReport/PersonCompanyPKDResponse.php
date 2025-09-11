<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\FullReport;

use Rudashi\GusApi\Contracts\Response;

readonly class PersonCompanyPKDResponse implements Response
{
    public function __construct(
        public string $pkdKod,
        public string $pkdNazwa,
        public string $pkdPrzewazajace,
        public string $silosSymbol,
        public string $silosId = '',
        public string $dataSkresleniaDzialalnosciZRegon = '',
    ) {
    }

    /**
     * @return array<string, string>
     */
    public function result(): array
    {
        return (array) $this;
    }

    public static function forPerson(
        string $fiz_pkd_Kod,
        string $fiz_pkd_Nazwa,
        string $fiz_pkd_Przewazajace,
        string $fiz_SilosID,
        string $fiz_Silos_Symbol,
        string $fiz_dataSkresleniaDzialalnosciZRegon,
    ): self {
        return new self(
            pkdKod: $fiz_pkd_Kod,
            pkdNazwa: $fiz_pkd_Nazwa,
            pkdPrzewazajace: $fiz_pkd_Przewazajace,
            silosSymbol: $fiz_Silos_Symbol,
            silosId: $fiz_SilosID,
            dataSkresleniaDzialalnosciZRegon: $fiz_dataSkresleniaDzialalnosciZRegon,
        );
    }

    public static function forLocal(
        string $lokfiz_pkd_Kod,
        string $lokfiz_pkd_Nazwa,
        string $lokfiz_pkd_Przewazajace,
        string $lokfiz_Silos_Symbol,
    ): self {
        return new self(
            pkdKod: $lokfiz_pkd_Kod,
            pkdNazwa: $lokfiz_pkd_Nazwa,
            pkdPrzewazajace: $lokfiz_pkd_Przewazajace,
            silosSymbol: $lokfiz_Silos_Symbol,
        );
    }
}
