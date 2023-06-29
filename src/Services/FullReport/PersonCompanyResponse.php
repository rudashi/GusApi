<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\FullReport;

use Rudashi\GusApi\Responses\ResponseInterface;

class PersonCompanyResponse implements ResponseInterface
{
    public function __construct(
        public readonly string $fiz_regon9,
        public readonly string $fiz_nazwa,
        public readonly string $fiz_nazwaSkrocona,
        public readonly string $fiz_dataPowstania,
        public readonly string $fiz_dataRozpoczeciaDzialalnosci,
        public readonly string $fiz_dataWpisuDzialalnosciDoRegon,
        public readonly string $fiz_dataZawieszeniaDzialalnosci,
        public readonly string $fiz_dataWznowieniaDzialalnosci,
        public readonly string $fiz_dataZaistnieniaZmianyDzialalnosci,
        public readonly string $fiz_dataZakonczeniaDzialalnosci,
        public readonly string $fiz_adSiedzKraj_Symbol,
        public readonly string $fiz_adSiedzWojewodztwo_Symbol,
        public readonly string $fiz_adSiedzPowiat_Symbol,
        public readonly string $fiz_adSiedzGmina_Symbol,
        public readonly string $fiz_adSiedzKodPocztowy,
        public readonly string $fiz_adSiedzMiejscowoscPoczty_Symbol,
        public readonly string $fiz_adSiedzMiejscowosc_Symbol,
        public readonly string $fiz_adSiedzUlica_Symbol,
        public readonly string $fiz_adSiedzNumerNieruchomosci,
        public readonly string $fiz_adSiedzNumerLokalu,
        public readonly string $fiz_adSiedzNietypoweMiejsceLokalizacji,
        public readonly string $fiz_numerTelefonu,
        public readonly string $fiz_numerWewnetrznyTelefonu,
        public readonly string $fiz_numerFaksu,
        public readonly string $fiz_adresEmail,
        public readonly string $fiz_adresStronyinternetowej,
        public readonly string $fiz_adSiedzKraj_Nazwa,
        public readonly string $fiz_adSiedzWojewodztwo_Nazwa,
        public readonly string $fiz_adSiedzPowiat_Nazwa,
        public readonly string $fiz_adSiedzGmina_Nazwa,
        public readonly string $fiz_adSiedzMiejscowosc_Nazwa,
        public readonly string $fiz_adSiedzMiejscowoscPoczty_Nazwa,
        public readonly string $fiz_adSiedzUlica_Nazwa,
        public readonly string $fiz_adresEmail2 = '',
        public readonly string $fiz_dataOrzeczeniaOUpadlosci = '',
        public readonly string $fiz_dataZakonczeniaPostepowaniaUpadlosciowego = '',
        public readonly string $fizC_dataWpisuDoRejestruEwidencji = '',
        public readonly string $fizC_dataSkresleniaZRejestruEwidencji = '',
        public readonly string $fizC_numerWRejestrzeEwidencji = '',
        public readonly string $fizC_OrganRejestrowy_Symbol = '',
        public readonly string $fizC_OrganRejestrowy_Nazwa = '',
        public readonly string $fizC_RodzajRejestru_Symbol = '',
        public readonly string $fizC_RodzajRejestru_Nazwa = '',
        public readonly string $fizC_NiePodjetoDzialalnosci = '',
        public readonly string $fizP_dataWpisuDoRejestruEwidencji = '',
        public readonly string $fizP_numerWRejestrzeEwidencji = '',
        public readonly string $fizP_OrganRejestrowy_Symbol = '',
        public readonly string $fizP_OrganRejestrowy_Nazwa = '',
        public readonly string $fizP_RodzajRejestru_Symbol = '',
        public readonly string $fizP_RodzajRejestru_Nazwa = '',
        public readonly string $fiz_dataSkresleniaDzialalnosciZRegon = '',
        public readonly string $fiz_dataSkresleniaDzialalanosciZRegon = '',
    ) {
    }

    public function result(): array
    {
        return (array) $this;
    }
}
