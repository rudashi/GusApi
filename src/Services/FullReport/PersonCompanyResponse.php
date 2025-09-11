<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\FullReport;

use Rudashi\GusApi\Contracts\Response;

readonly class PersonCompanyResponse implements Response
{
    public function __construct(
        public string $fiz_regon9,
        public string $fiz_nazwa,
        public string $fiz_nazwaSkrocona,
        public string $fiz_dataPowstania,
        public string $fiz_dataRozpoczeciaDzialalnosci,
        public string $fiz_dataWpisuDzialalnosciDoRegon,
        public string $fiz_dataZawieszeniaDzialalnosci,
        public string $fiz_dataWznowieniaDzialalnosci,
        public string $fiz_dataZaistnieniaZmianyDzialalnosci,
        public string $fiz_dataZakonczeniaDzialalnosci,
        public string $fiz_adSiedzKraj_Symbol,
        public string $fiz_adSiedzWojewodztwo_Symbol,
        public string $fiz_adSiedzPowiat_Symbol,
        public string $fiz_adSiedzGmina_Symbol,
        public string $fiz_adSiedzKodPocztowy,
        public string $fiz_adSiedzMiejscowoscPoczty_Symbol,
        public string $fiz_adSiedzMiejscowosc_Symbol,
        public string $fiz_adSiedzUlica_Symbol,
        public string $fiz_adSiedzNumerNieruchomosci,
        public string $fiz_adSiedzNumerLokalu,
        public string $fiz_adSiedzNietypoweMiejsceLokalizacji,
        public string $fiz_numerTelefonu,
        public string $fiz_numerWewnetrznyTelefonu,
        public string $fiz_numerFaksu,
        public string $fiz_adresEmail,
        public string $fiz_adresStronyinternetowej,
        public string $fiz_adSiedzKraj_Nazwa,
        public string $fiz_adSiedzWojewodztwo_Nazwa,
        public string $fiz_adSiedzPowiat_Nazwa,
        public string $fiz_adSiedzGmina_Nazwa,
        public string $fiz_adSiedzMiejscowosc_Nazwa,
        public string $fiz_adSiedzMiejscowoscPoczty_Nazwa,
        public string $fiz_adSiedzUlica_Nazwa,
        public string $fiz_adresEmail2 = '',
        public string $fiz_dataOrzeczeniaOUpadlosci = '',
        public string $fiz_dataZakonczeniaPostepowaniaUpadlosciowego = '',
        public string $fizC_dataWpisuDoRejestruEwidencji = '',
        public string $fizC_dataSkresleniaZRejestruEwidencji = '',
        public string $fizC_numerWRejestrzeEwidencji = '',
        public string $fizC_OrganRejestrowy_Symbol = '',
        public string $fizC_OrganRejestrowy_Nazwa = '',
        public string $fizC_RodzajRejestru_Symbol = '',
        public string $fizC_RodzajRejestru_Nazwa = '',
        public string $fizC_NiePodjetoDzialalnosci = '',
        public string $fizP_dataWpisuDoRejestruEwidencji = '',
        public string $fizP_numerWRejestrzeEwidencji = '',
        public string $fizP_OrganRejestrowy_Symbol = '',
        public string $fizP_OrganRejestrowy_Nazwa = '',
        public string $fizP_RodzajRejestru_Symbol = '',
        public string $fizP_RodzajRejestru_Nazwa = '',
        public string $fiz_dataSkresleniaDzialalnosciZRegon = '',
        public string $fiz_dataSkresleniaDzialalanosciZRegon = '',
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
