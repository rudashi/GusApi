<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Enums;

use Rudashi\GusApi\Contracts\Response;
use Rudashi\GusApi\Responses\Collection;
use Rudashi\GusApi\Services\FullReport\CompanyPartnersResponse;
use Rudashi\GusApi\Services\FullReport\CompanyPKDResponse;
use Rudashi\GusApi\Services\FullReport\CompanyResponse;
use Rudashi\GusApi\Services\FullReport\CompanyTypeResponse;
use Rudashi\GusApi\Services\FullReport\LocalResponse;
use Rudashi\GusApi\Services\FullReport\PersonCompanyPKDResponse;
use Rudashi\GusApi\Services\FullReport\PersonCompanyResponse;
use Rudashi\GusApi\Services\FullReport\PersonResponse;

enum ReportName: string
{
    case PERSON_GENERAL = 'BIR11OsFizycznaDaneOgolne';
    case PERSON_CEIDG = 'BIR11OsFizycznaDzialalnoscCeidg';
    case PERSON_AGRO = 'BIR11OsFizycznaDzialalnoscRolnicza';
    case PERSON_OTHER = 'BIR11OsFizycznaDzialalnoscPozostala';
    case PERSON_DELETED = 'BIR11OsFizycznaDzialalnoscSkreslonaDo20141108';
    case PERSON_PKD = 'BIR11OsFizycznaPkd';
    case PERSON_LOCALS = 'BIR11OsFizycznaListaJednLokalnych';
    case LOCAL_PERSON = 'BIR11JednLokalnaOsFizycznej';
    case LOCAL_PERSON_PKD = 'BIR11JednLokalnaOsFizycznejPkd';
    case COMPANY = 'BIR11OsPrawna';
    case COMPANY_PKD = 'BIR11OsPrawnaPkd';
    case COMPANY_LOCALS = 'BIR11OsPrawnaListaJednLokalnych';
    case COMPANY_PARTNERS = 'BIR11OsPrawnaSpCywilnaWspolnicy';
    case COMPANY_TYPE = 'BIR11TypPodmiotu';
    case LOCAL_COMPANY = 'BIR11JednLokalnaOsPrawnej';
    case LOCAL_COMPANY_PKD = 'BIR11JednLokalnaOsPrawnejPkd';

    public function equals(ReportName $report): bool
    {
        return $this === $report;
    }

    public function type(): CompanyType
    {
        return match ($this) {
            self::PERSON_GENERAL,
            self::PERSON_CEIDG,
            self::PERSON_AGRO,
            self::PERSON_OTHER,
            self::PERSON_DELETED,
            self::PERSON_PKD,
            self::PERSON_LOCALS => CompanyType::PERSON,
            self::LOCAL_PERSON,
            self::LOCAL_PERSON_PKD => CompanyType::LOCAL_PERSON,
            self::COMPANY,
            self::COMPANY_PKD,
            self::COMPANY_LOCALS,
            self::COMPANY_PARTNERS,
            self::COMPANY_TYPE => CompanyType::COMPANY,
            self::LOCAL_COMPANY,
            self::LOCAL_COMPANY_PKD => CompanyType::LOCAL_COMPANY,
        };
    }

    /**
     * @param array{dane: \SimpleXMLElement|\SimpleXMLElement[]} $response
     */
    public function toResponse(array $response): Response
    {
        return match ($this) {
            self::PERSON_GENERAL => new PersonResponse(...self::map((array) $response['dane'])),
            self::PERSON_CEIDG,
            self::PERSON_AGRO,
            self::PERSON_OTHER,
            self::PERSON_DELETED => new PersonCompanyResponse(...self::map((array) $response['dane'])),
            self::PERSON_PKD => Collection::each(
                static fn ($item) => PersonCompanyPKDResponse::forPerson(...self::map((array) $item)),
                $response['dane'],
            ),
            self::PERSON_LOCALS,
            self::LOCAL_PERSON => LocalResponse::forPerson(...self::map((array) $response['dane'])),
            self::LOCAL_PERSON_PKD => Collection::each(
                static fn ($item) => PersonCompanyPKDResponse::forLocal(...self::map((array) $item)),
                $response['dane'],
            ),
            self::COMPANY => new CompanyResponse(...self::map((array) $response['dane'])),
            self::COMPANY_PKD => Collection::each(
                static fn ($item) => CompanyPKDResponse::forCompany(...self::map((array) $item)),
                $response['dane'],
            ),
            self::COMPANY_LOCALS => Collection::each(
                static fn ($item) => LocalResponse::forCompany(...self::map((array) $item)),
                $response['dane'],
            ),
            self::COMPANY_PARTNERS => Collection::each(
                static fn ($item) => new CompanyPartnersResponse(...(array) $item),
                $response['dane'],
            ),
            self::COMPANY_TYPE => CompanyTypeResponse::of((string) $response['dane']->Typ),
            self::LOCAL_COMPANY => LocalResponse::forCompany(...self::map((array) $response['dane'])),
            self::LOCAL_COMPANY_PKD => new Collection([
                CompanyPKDResponse::forLocalCompany(...self::map((array) $response['dane'])),
            ]),
        };
    }

    /**
     * @param array<array-key, string|\SimpleXMLElement> $items
     *
     * @return array<string, string>
     */
    private static function map(array $items): array
    {
        return array_map(static fn ($value) => (string) $value, $items);
    }
}
