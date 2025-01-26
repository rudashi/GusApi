<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Tests\ClientTest;

use const Rudashi\GusApi\Tests\API_KEY;

use PHPUnit\Framework\TestCase;
use Rudashi\GusApi\Enums\CompanyType;
use Rudashi\GusApi\Enums\GetValue;
use Rudashi\GusApi\Enums\ReportName;
use Rudashi\GusApi\Exceptions\NotFoundEntity;
use Rudashi\GusApi\Requests\FullReportRequest;
use Rudashi\GusApi\Requests\GetValueRequest;
use Rudashi\GusApi\Requests\LoginRequest;
use Rudashi\GusApi\Requests\LogoutRequest;
use Rudashi\GusApi\Requests\SearchDataRequest;
use Rudashi\GusApi\Responses\Collection;
use Rudashi\GusApi\Services\CompanyModel;
use Rudashi\GusApi\Services\FullReport\CompanyPartnersResponse;
use Rudashi\GusApi\Services\FullReport\CompanyPKDResponse;
use Rudashi\GusApi\Services\FullReport\CompanyResponse;
use Rudashi\GusApi\Services\FullReport\CompanyTypeResponse;
use Rudashi\GusApi\Services\FullReport\LocalResponse;
use Rudashi\GusApi\Services\FullReport\PersonCompanyPKDResponse;
use Rudashi\GusApi\Services\FullReport\PersonCompanyResponse;
use Rudashi\GusApi\Services\FullReport\PersonResponse;
use Rudashi\GusApi\Services\SearchParameters;

use function Rudashi\GusApi\Tests\client;

uses(TestCase::class);

it('returns empty string when login fails', function () {
    $response = client()->login(new LoginRequest('test'));

    expect($response->result())
        ->toBeString()
        ->toBeEmpty();
});

it('returns session id when login pass', function () {
    $response = client()->login(new LoginRequest(API_KEY));

    expect($response->result())
        ->toBeString()
        ->toHaveLength(20);
});

it('can logout', function () {
    $client = client();
    $session = $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->logout(new LogoutRequest($session));

    expect($response->result())
        ->toBeTrue();
});

/**
 * Action::GET_VALUE
 */
it('can get service value about data status', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getValue(new GetValueRequest(GetValue::DATA_STATUS));

    expect($response->result())
        ->toBeString()
        ->toHaveLength(10);
});

it('returns empty string for data status when not logged', function () {
    $response = client()->getValue(new GetValueRequest(GetValue::DATA_STATUS));

    expect($response->result())
        ->toBeString()
        ->toBeEmpty();
});

it('can get service value about message code', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getValue(new GetValueRequest(GetValue::MESSAGE_CODE));

    expect($response->result())
        ->toBeString()
        ->toBe('0');
});

it('returns empty string for message code when not logged', function () {
    $response = client()->getValue(new GetValueRequest(GetValue::MESSAGE_CODE));

    expect($response->result())
        ->toBeString()
        ->toBeEmpty();
});

it('can get service value about message', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getValue(new GetValueRequest(GetValue::MESSAGE_CONTENT));

    expect($response->result())
        ->toBeString()
        ->toBeEmpty();
});

it('can get service value about session status', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getValue(new GetValueRequest(GetValue::SESSION_STATUS));

    expect($response->result())
        ->toBeString()
        ->toBe('1');
});

it('returns empty string for session status when not logged', function () {
    $response = client()->getValue(new GetValueRequest(GetValue::SESSION_STATUS));

    expect($response->result())
        ->toBeString()
        ->toBeEmpty();
});

it('can get service value about service status', function () {
    $response = client()->getValue(new GetValueRequest(GetValue::SERVICE_STATUS));

    expect($response->result())
        ->toBeString()
        ->toBe('1');
});

it('can get service value about service message', function () {
    $response = client()->getValue(new GetValueRequest(GetValue::SERVICE_MESSAGE));

    expect($response->result())
        ->toBeString()
        ->toBe('Usluga dostepna');
});

/**
 * Action::SEARCH_DATA
 */

/*************************      NIP         **********************/
it('can find business entity by NIP', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->searchEntity(
        new SearchDataRequest(new SearchParameters(
            nip: '5561007611',
        ))
    );

    expect($response->result())
        ->toBeInstanceOf(CompanyModel::class)
        ->Nip->toBe('5561007611');
});

it('throws an Exception when NIP business entity not exists', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    expect(
        fn () => $client->searchEntity(
            new SearchDataRequest(new SearchParameters(
                nip: '5561007',
            ))
        )->result()
    )->toThrow(
        NotFoundEntity::class,
        'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
    );
});

it('throws an Exception when not logged while searching entity by NIP', function () {
    $client = client();

    expect(
        fn () => $client->searchEntity(
            new SearchDataRequest(new SearchParameters(
                nip: '5561007',
            ))
        )->result()
    )->toThrow(
        NotFoundEntity::class,
        'Entity not found.'
    );
});

/*************************      KRS         **********************/
it('can find business entity by KRS', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->searchEntity(
        new SearchDataRequest(new SearchParameters(
            krs: '0000496427',
        ))
    );

    expect($response->result())
        ->toBeInstanceOf(CompanyModel::class)
        ->Nip->toBe('5561007611');
});

it('throws an Exception when KRS business entity not exists', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    expect(
        fn () => $client->searchEntity(
            new SearchDataRequest(new SearchParameters(
                krs: '00496427',
            ))
        )->result()
    )->toThrow(
        NotFoundEntity::class,
        'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
    );
});

it('throws an Exception when not logged while searching entity by KRS', function () {
    $client = client();

    expect(
        fn () => $client->searchEntity(
            new SearchDataRequest(new SearchParameters(
                krs: '0000496427',
            ))
        )->result()
    )->toThrow(
        NotFoundEntity::class,
        'Entity not found.'
    );
});

/*************************      REGON         **********************/
it('can find business entity by REGON', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->searchEntity(
        new SearchDataRequest(new SearchParameters(
            regon: '091187826',
        ))
    );

    expect($response->result())
        ->toBeInstanceOf(CompanyModel::class)
        ->Nip->toBe('5561007611')
        ->Regon->toBe('091187826');
});

it('throws an Exception when REGON business entity not exists', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    expect(
        fn () => $client->searchEntity(
            new SearchDataRequest(new SearchParameters(
                regon: '91187826',
            ))
        )->result()
    )->toThrow(
        NotFoundEntity::class,
        'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
    );
});

it('throws an Exception when not logged while searching entity by REGON', function () {
    $client = client();

    expect(
        fn () => $client->searchEntity(
            new SearchDataRequest(new SearchParameters(
                regon: '091187826',
            ))
        )->result()
    )->toThrow(
        NotFoundEntity::class,
        'Entity not found.'
    );
});

/*************************      NIPY         **********************/
it('can find multiple business entities by NIP', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->searchEntity(
        request: new SearchDataRequest(new SearchParameters(
            nipy: '5561007611,5260030236',
        )),
        collect: true
    );

    expect($response->result())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(2)
        ->sequence(
            fn ($item) => $item->Nip->toBe('5561007611'),
            fn ($item) => $item->Nip->toBe('5260030236'),
        );
});

it('returns one entity in collection when searching multiple NIP', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->searchEntity(
        request: new SearchDataRequest(new SearchParameters(
            nipy: '5561007611,526003023',
        )),
        collect: true
    );

    expect($response->result())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->sequence(
            fn ($item) => $item->Nip->toBe('5561007611'),
        );
});

it('throws an Exception when not found any NIP', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    expect(fn () => $client->searchEntity(
        request: new SearchDataRequest(new SearchParameters(
            nipy: '556100761,526003023',
        )),
        collect: true
    )->result())
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
        );
});

it('throws an Exception when not logged while searching multiple entities by NIP', function () {
    $client = client();

    expect(
        fn () => $client->searchEntity(
            new SearchDataRequest(new SearchParameters(
                nipy: '556100761,526003023',
            ))
        )->result()
    )->toThrow(
        NotFoundEntity::class,
        'Entity not found.'
    );
});

/*************************      KRSY         **********************/
it('can find multiple business entities by KRS', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->searchEntity(
        request: new SearchDataRequest(new SearchParameters(
            krsy: '0000496427,0000149371',
        )),
        collect: true
    );

    expect($response->result())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(2)
        ->sequence(
            fn ($item) => $item->Nip->toBe('5561007611'),
            fn ($item) => $item->Nip->toBe('5260030236'),
        );
});

it('returns one entity in collection when searching multiple KRS', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->searchEntity(
        request: new SearchDataRequest(new SearchParameters(
            krsy: '0000496427,000149371',
        )),
        collect: true
    );

    expect($response->result())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->sequence(
            fn ($item) => $item->Nip->toBe('5561007611'),
        );
});

it('throws an Exception when not found any KRS', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    expect(fn () => $client->searchEntity(
        request: new SearchDataRequest(new SearchParameters(
            krsy: '000496427,000149371',
        )),
        collect: true
    )->result())
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
        );
});

it('throws an Exception when not logged while searching multiple entities by KRS', function () {
    $client = client();

    expect(
        fn () => $client->searchEntity(
            new SearchDataRequest(new SearchParameters(
                krsy: '000496427,000149371',
            ))
        )->result()
    )->toThrow(
        NotFoundEntity::class,
        'Entity not found.'
    );
});

/*************************      REGONY         **********************/
it('can find multiple business entities by REGON', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->searchEntity(
        request: new SearchDataRequest(new SearchParameters(
            regony: '091187826,010421047',
        )),
        collect: true
    );

    expect($response->result())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(2)
        ->sequence(
            fn ($item) => $item->Regon->toBe('091187826'),
            fn ($item) => $item->Regon->toBe('010421047'),
        );
});

it('returns one entity in collection when searching multiple REGON', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->searchEntity(
        request: new SearchDataRequest(new SearchParameters(
            regony: '091187826,10421047',
        )),
        collect: true
    );

    expect($response->result())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->sequence(
            fn ($item) => $item->Regon->toBe('091187826'),
        );
});

it('throws an Exception when not found any REGON', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    expect(fn () => $client->searchEntity(
        request: new SearchDataRequest(new SearchParameters(
            regony: '09118726,1042147',
        )),
        collect: true
    )->result())
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
        );
});

it('throws an Exception when not logged while searching multiple entities by REGON', function () {
    $client = client();

    expect(
        fn () => $client->searchEntity(
            new SearchDataRequest(new SearchParameters(
                regony: '09118726,1042147',
            ))
        )->result()
    )->toThrow(
        NotFoundEntity::class,
        'Entity not found.'
    );
});

/*************************      REGONY_14         **********************/
it('can find business entity by REGON_14', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->searchEntity(
        new SearchDataRequest(new SearchParameters(
            regony14: '00000002300041',
        ))
    );

    expect($response->result())
        ->toBeInstanceOf(CompanyModel::class)
        ->Nip->toBe('')
        ->Regon->toBe('00000002300041');
});

it('throws an Exception when REGON_14 business entity not exists', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    expect(
        fn () => $client->searchEntity(
            new SearchDataRequest(new SearchParameters(
                regony14: '000002300041',
            ))
        )->result()
    )->toThrow(
        NotFoundEntity::class,
        'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
    );
});

it('throws an Exception when not logged while searching multiple entities by REGON_14', function () {
    $client = client();

    expect(
        fn () => $client->searchEntity(
            new SearchDataRequest(new SearchParameters(
                regony14: '000002300041',
            ))
        )->result()
    )->toThrow(
        NotFoundEntity::class,
        'Entity not found.'
    );
});

/**
 * Action::FULL_REPORT
 */

it('can get information about person by `PERSON_GENERAL`', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getFullReport(
        new FullReportRequest(
            regon: '340843382',
            report: ReportName::PERSON_GENERAL,
        )
    );

    expect($response->result())
        ->toBeInstanceOf(PersonResponse::class)
        ->toHaveProperty('fiz_regon9', '340843382');
});

it('can get person CEIDG list by `PERSON_CEIDG`', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getFullReport(
        new FullReportRequest(
            regon: '151482826',
            report: ReportName::PERSON_CEIDG,
        )
    );

    expect($response->result())
        ->toBeInstanceOf(PersonCompanyResponse::class)
        ->toHaveProperty('fiz_regon9', '151482826');
});

it('can get information about person by `PERSON_AGRO`', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getFullReport(
        new FullReportRequest(
            regon: '530532330',
            report: ReportName::PERSON_AGRO,
        )
    );

    expect($response->result())
        ->toBeInstanceOf(PersonCompanyResponse::class)
        ->toHaveProperty('fiz_regon9', '530532330');
});

it('can get information about person by `PERSON_OTHER`', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getFullReport(
        new FullReportRequest(
            regon: '278287718',
            report: ReportName::PERSON_OTHER,
        )
    );

    expect($response->result())
        ->toBeInstanceOf(PersonCompanyResponse::class)
        ->toHaveProperty('fiz_regon9', '278287718');
});

it('can get information about person by `PERSON_DELETED`', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getFullReport(
        new FullReportRequest(
            regon: '340843382',
            report: ReportName::PERSON_DELETED,
        )
    );

    expect($response->result())
        ->toBeInstanceOf(PersonCompanyResponse::class)
        ->toHaveProperty('fiz_regon9', '340843382');
});

it('can get person PKD list by `PERSON_PKD`', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getFullReport(
        new FullReportRequest(
            regon: '151482826',
            report: ReportName::PERSON_PKD,
        )
    );

    expect($response->result())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(50)
        ->each(
            fn ($item) => $item
                ->toBeInstanceOf(PersonCompanyPKDResponse::class)
                ->pkdKod->not->toBe('')
                ->pkdNazwa->not->toBe('')
                ->pkdPrzewazajace->not->toBe('')
        );
});

it('can get person locals by `PERSON_LOCALS`', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getFullReport(
        new FullReportRequest(
            regon: '151482826',
            report: ReportName::PERSON_LOCALS,
        )
    );

    expect($response->result())
        ->toBeInstanceOf(LocalResponse::class)
        ->toHaveProperty('regon14', '15148282600033');
});

it('can get information about local person by `LOCAL_PERSON`', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getFullReport(
        new FullReportRequest(
            regon: '15148282600033',
            report: ReportName::LOCAL_PERSON,
        )
    );

    expect($response->result())
        ->toBeInstanceOf(LocalResponse::class)
        ->toHaveProperty('regon14', '15148282600033');
});

it('can get local person PKD list by `LOCAL_PERSON_PKD`', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getFullReport(
        new FullReportRequest(
            regon: '15148282600033',
            report: ReportName::LOCAL_PERSON_PKD,
        )
    );

    expect($response->result())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(2)
        ->each(
            fn ($item) => $item
                ->toBeInstanceOf(PersonCompanyPKDResponse::class)
                ->pkdKod->not->toBe('')
                ->pkdNazwa->not->toBe('')
                ->pkdPrzewazajace->not->toBe('')
                ->silosSymbol->not->toBe('')
        );
});

it('can get report about company by `COMPANY`', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getFullReport(
        new FullReportRequest(
            regon: '091187826',
            report: ReportName::COMPANY,
        )
    );

    expect($response->result())
        ->toBeInstanceOf(CompanyResponse::class)
        ->toHaveProperty('praw_nip', '5561007611');
});

it('can get company PKD list by `COMPANY_PKD`', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getFullReport(
        new FullReportRequest(
            regon: '091187826',
            report: ReportName::COMPANY_PKD,
        )
    );

    expect($response->result())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(38)
        ->each(
            fn ($item) => $item
                ->toBeInstanceOf(CompanyPKDResponse::class)
                ->pkdKod->not->toBe('')
                ->pkdNazwa->not->toBe('')
                ->pkdPrzewazajace->not->toBe('')
        );
});

it('can get company locals by `COMPANY_LOCALS`', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getFullReport(
        new FullReportRequest(
            regon: '016298263',
            report: ReportName::COMPANY_LOCALS,
        )
    );

    expect($response->result())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(23)
        ->each(fn ($item) => $item->toBeInstanceOf(LocalResponse::class));
});

it('can get company partners by `COMPANY_PARTNERS`', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getFullReport(
        new FullReportRequest(
            regon: '091187826',
            report: ReportName::COMPANY_PARTNERS,
        )
    );

    expect($response->result())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(4)
        ->each(fn ($item) => $item->toBeInstanceOf(CompanyPartnersResponse::class));
});

it('can get type of the company by `COMPANY_TYPE`', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getFullReport(
        new FullReportRequest(
            regon: '091187826',
            report: ReportName::COMPANY_TYPE,
        )
    );

    expect($response->result())
        ->toBeInstanceOf(CompanyTypeResponse::class)
        ->result()->toBe(CompanyType::COMPANY);
});

it('can get information about entity by `LOCAL_COMPANY`', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getFullReport(
        new FullReportRequest(
            regon: '01629826305798',
            report: ReportName::LOCAL_COMPANY,
        )
    );

    expect($response->result())
        ->toBeInstanceOf(LocalResponse::class)
        ->toHaveProperty('regon14', '01629826305798');
});

it('can get entity PKD list by `LOCAL_COMPANY_PKD`', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    $response = $client->getFullReport(
        new FullReportRequest(
            regon: '00000002300041',
            report: ReportName::LOCAL_COMPANY_PKD,
        )
    );

    expect($response->result())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->each(
            fn ($item) => $item
                ->toBeInstanceOf(CompanyPKDResponse::class)
                ->pkdKod->not->toBe('')
                ->pkdNazwa->not->toBe('')
                ->pkdPrzewazajace->not->toBe('')
        );
});

it('throws an Exception when not found entity report', function () {
    $client = client();
    $client->login(new LoginRequest(API_KEY))->result();

    expect(fn () => $client->getFullReport(
        new FullReportRequest(
            regon: '091187826',
            report: ReportName::PERSON_GENERAL,
        )
    )->result())
        ->toThrow(
            NotFoundEntity::class,
            'Nieprawidłowa lub pusta nazwa raportu lub nieprawidłowy identyfikator.'
        );
});
