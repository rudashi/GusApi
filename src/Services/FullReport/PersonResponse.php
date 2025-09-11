<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\FullReport;

use Rudashi\GusApi\Contracts\Response;

readonly class PersonResponse implements Response
{
    public function __construct(
        public string $fiz_regon9,
        public string $fiz_nip,
        public string $fiz_statusNip,
        public string $fiz_nazwisko,
        public string $fiz_imie1,
        public string $fiz_imie2,
        public string $fiz_dataWpisuPodmiotuDoRegon,
        public string $fiz_dataZaistnieniaZmiany,
        public string $fiz_dataSkresleniaPodmiotuZRegon,
        public string $fiz_podstawowaFormaPrawna_Symbol,
        public string $fiz_szczegolnaFormaPrawna_Symbol,
        public string $fiz_formaFinansowania_Symbol,
        public string $fiz_formaWlasnosci_Symbol,
        public string $fiz_podstawowaFormaPrawna_Nazwa,
        public string $fiz_szczegolnaFormaPrawna_Nazwa,
        public string $fiz_formaFinansowania_Nazwa,
        public string $fiz_formaWlasnosci_Nazwa,
        public string $fiz_dzialalnoscCeidg,
        public string $fiz_dzialalnoscRolnicza,
        public string $fiz_dzialalnoscPozostala,
        public string $fiz_dzialalnoscSkreslonaDo20141108,
        public string $fiz_liczbaJednLokalnych,
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
