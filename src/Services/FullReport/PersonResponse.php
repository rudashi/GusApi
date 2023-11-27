<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\FullReport;

use Rudashi\GusApi\Contracts\Response;

class PersonResponse implements Response
{
    public function __construct(
        public readonly string $fiz_regon9,
        public readonly string $fiz_nip,
        public readonly string $fiz_statusNip,
        public readonly string $fiz_nazwisko,
        public readonly string $fiz_imie1,
        public readonly string $fiz_imie2,
        public readonly string $fiz_dataWpisuPodmiotuDoRegon,
        public readonly string $fiz_dataZaistnieniaZmiany,
        public readonly string $fiz_dataSkresleniaPodmiotuZRegon,
        public readonly string $fiz_podstawowaFormaPrawna_Symbol,
        public readonly string $fiz_szczegolnaFormaPrawna_Symbol,
        public readonly string $fiz_formaFinansowania_Symbol,
        public readonly string $fiz_formaWlasnosci_Symbol,
        public readonly string $fiz_podstawowaFormaPrawna_Nazwa,
        public readonly string $fiz_szczegolnaFormaPrawna_Nazwa,
        public readonly string $fiz_formaFinansowania_Nazwa,
        public readonly string $fiz_formaWlasnosci_Nazwa,
        public readonly string $fiz_dzialalnoscCeidg,
        public readonly string $fiz_dzialalnoscRolnicza,
        public readonly string $fiz_dzialalnoscPozostala,
        public readonly string $fiz_dzialalnoscSkreslonaDo20141108,
        public readonly string $fiz_liczbaJednLokalnych,
    ) {
    }

    public function result(): array
    {
        return (array) $this;
    }
}
