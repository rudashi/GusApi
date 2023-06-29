<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\FullReport;

use Rudashi\GusApi\Responses\ResponseInterface;

class CompanyResponse implements ResponseInterface
{
    public function __construct(
        public readonly string $praw_regon9,
        public readonly string $praw_nip,
        public readonly string $praw_statusNip,
        public readonly string $praw_nazwa,
        public readonly string $praw_nazwaSkrocona,
        public readonly string $praw_numerWRejestrzeEwidencji,
        public readonly string $praw_dataWpisuDoRejestruEwidencji,
        public readonly string $praw_dataPowstania,
        public readonly string $praw_dataRozpoczeciaDzialalnosci,
        public readonly string $praw_dataWpisuDoRegon,
        public readonly string $praw_dataZawieszeniaDzialalnosci,
        public readonly string $praw_dataWznowieniaDzialalnosci,
        public readonly string $praw_dataZaistnieniaZmiany,
        public readonly string $praw_dataZakonczeniaDzialalnosci,
        public readonly string $praw_dataSkresleniaZRegon,
        public readonly string $praw_dataOrzeczeniaOUpadlosci,
        public readonly string $praw_dataZakonczeniaPostepowaniaUpadlosciowego,
        public readonly string $praw_adSiedzKraj_Symbol,
        public readonly string $praw_adSiedzWojewodztwo_Symbol,
        public readonly string $praw_adSiedzPowiat_Symbol,
        public readonly string $praw_adSiedzGmina_Symbol,
        public readonly string $praw_adSiedzKodPocztowy,
        public readonly string $praw_adSiedzMiejscowoscPoczty_Symbol,
        public readonly string $praw_adSiedzMiejscowosc_Symbol,
        public readonly string $praw_adSiedzUlica_Symbol,
        public readonly string $praw_adSiedzNumerNieruchomosci,
        public readonly string $praw_adSiedzNumerLokalu,
        public readonly string $praw_adSiedzNietypoweMiejsceLokalizacji,
        public readonly string $praw_numerTelefonu,
        public readonly string $praw_numerWewnetrznyTelefonu,
        public readonly string $praw_numerFaksu,
        public readonly string $praw_adresEmail,
        public readonly string $praw_adresStronyinternetowej,
        public readonly string $praw_adSiedzKraj_Nazwa,
        public readonly string $praw_adSiedzWojewodztwo_Nazwa,
        public readonly string $praw_adSiedzPowiat_Nazwa,
        public readonly string $praw_adSiedzGmina_Nazwa,
        public readonly string $praw_adSiedzMiejscowosc_Nazwa,
        public readonly string $praw_adSiedzMiejscowoscPoczty_Nazwa,
        public readonly string $praw_adSiedzUlica_Nazwa,
        public readonly string $praw_podstawowaFormaPrawna_Symbol,
        public readonly string $praw_szczegolnaFormaPrawna_Symbol,
        public readonly string $praw_formaFinansowania_Symbol,
        public readonly string $praw_formaWlasnosci_Symbol,
        public readonly string $praw_organZalozycielski_Symbol,
        public readonly string $praw_organRejestrowy_Symbol,
        public readonly string $praw_rodzajRejestruEwidencji_Symbol,
        public readonly string $praw_podstawowaFormaPrawna_Nazwa,
        public readonly string $praw_szczegolnaFormaPrawna_Nazwa,
        public readonly string $praw_formaFinansowania_Nazwa,
        public readonly string $praw_formaWlasnosci_Nazwa,
        public readonly string $praw_organZalozycielski_Nazwa,
        public readonly string $praw_organRejestrowy_Nazwa,
        public readonly string $praw_rodzajRejestruEwidencji_Nazwa,
        public readonly string $praw_liczbaJednLokalnych,
    ) {
    }

    public function result(): array
    {
        return (array) $this;
    }
}
