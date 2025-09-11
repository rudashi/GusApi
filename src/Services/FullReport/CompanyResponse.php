<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\FullReport;

use Rudashi\GusApi\Contracts\Response;

readonly class CompanyResponse implements Response
{
    public function __construct(
        public string $praw_regon9,
        public string $praw_nip,
        public string $praw_statusNip,
        public string $praw_nazwa,
        public string $praw_nazwaSkrocona,
        public string $praw_numerWRejestrzeEwidencji,
        public string $praw_dataWpisuDoRejestruEwidencji,
        public string $praw_dataPowstania,
        public string $praw_dataRozpoczeciaDzialalnosci,
        public string $praw_dataWpisuDoRegon,
        public string $praw_dataZawieszeniaDzialalnosci,
        public string $praw_dataWznowieniaDzialalnosci,
        public string $praw_dataZaistnieniaZmiany,
        public string $praw_dataZakonczeniaDzialalnosci,
        public string $praw_dataSkresleniaZRegon,
        public string $praw_dataOrzeczeniaOUpadlosci,
        public string $praw_dataZakonczeniaPostepowaniaUpadlosciowego,
        public string $praw_adSiedzKraj_Symbol,
        public string $praw_adSiedzWojewodztwo_Symbol,
        public string $praw_adSiedzPowiat_Symbol,
        public string $praw_adSiedzGmina_Symbol,
        public string $praw_adSiedzKodPocztowy,
        public string $praw_adSiedzMiejscowoscPoczty_Symbol,
        public string $praw_adSiedzMiejscowosc_Symbol,
        public string $praw_adSiedzUlica_Symbol,
        public string $praw_adSiedzNumerNieruchomosci,
        public string $praw_adSiedzNumerLokalu,
        public string $praw_adSiedzNietypoweMiejsceLokalizacji,
        public string $praw_numerTelefonu,
        public string $praw_numerWewnetrznyTelefonu,
        public string $praw_numerFaksu,
        public string $praw_adresEmail,
        public string $praw_adresStronyinternetowej,
        public string $praw_adSiedzKraj_Nazwa,
        public string $praw_adSiedzWojewodztwo_Nazwa,
        public string $praw_adSiedzPowiat_Nazwa,
        public string $praw_adSiedzGmina_Nazwa,
        public string $praw_adSiedzMiejscowosc_Nazwa,
        public string $praw_adSiedzMiejscowoscPoczty_Nazwa,
        public string $praw_adSiedzUlica_Nazwa,
        public string $praw_podstawowaFormaPrawna_Symbol,
        public string $praw_szczegolnaFormaPrawna_Symbol,
        public string $praw_formaFinansowania_Symbol,
        public string $praw_formaWlasnosci_Symbol,
        public string $praw_organZalozycielski_Symbol,
        public string $praw_organRejestrowy_Symbol,
        public string $praw_rodzajRejestruEwidencji_Symbol,
        public string $praw_podstawowaFormaPrawna_Nazwa,
        public string $praw_szczegolnaFormaPrawna_Nazwa,
        public string $praw_formaFinansowania_Nazwa,
        public string $praw_formaWlasnosci_Nazwa,
        public string $praw_organZalozycielski_Nazwa,
        public string $praw_organRejestrowy_Nazwa,
        public string $praw_rodzajRejestruEwidencji_Nazwa,
        public string $praw_liczbaJednLokalnych,
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
