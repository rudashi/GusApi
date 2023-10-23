<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\FullReport;

use Rudashi\GusApi\Responses\ResponseInterface;

/**
 * @phpstan-consistent-constructor
 */
class PersonCompanyPKDResponse implements ResponseInterface
{
    public function __construct(
        public readonly string $pkdKod,
        public readonly string $pkdNazwa,
        public readonly string $pkdPrzewazajace,
        public readonly string $silosSymbol,
        public readonly string $silosId = '',
        public readonly string $dataSkresleniaDzialalnosciZRegon = '',
    ) {
    }

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
    ): static {
        return new static(
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
    ): static {
        return new static(
            pkdKod: $lokfiz_pkd_Kod,
            pkdNazwa: $lokfiz_pkd_Nazwa,
            pkdPrzewazajace: $lokfiz_pkd_Przewazajace,
            silosSymbol: $lokfiz_Silos_Symbol,
        );
    }
}
