<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Tests\GusApiTest;

use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use Rudashi\GusApi\Enums\CompanyType;
use Rudashi\GusApi\Exceptions\IncorrectDataStatus;
use Rudashi\GusApi\Exceptions\InvalidUserKey;
use Rudashi\GusApi\Exceptions\LimitedIdentifiers;
use Rudashi\GusApi\Exceptions\MissingSession;
use Rudashi\GusApi\Exceptions\NotFoundEntity;
use Rudashi\GusApi\Services\FullReport\CompanyResponse;
use Rudashi\GusApi\Services\FullReport\PersonCompanyResponse;

use function Rudashi\GusApi\Tests\api;

uses(TestCase::class);

it('can set session id', function () {
    $api = api()->setSessionId('abc');

    expect($api->getSessionId())
        ->toBe('abc');
});

it('throws an Exception when session not ', function () {
    expect(fn () => api()->getSessionId())
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('pass when session is started', function () {
    $api = api()->setSessionId('abc')->isLogged();

    expect($api)
        ->toBeTrue();
});

it('fails when session is not started', function () {
    $api = api()->isLogged();

    expect($api)
        ->toBeFalse();
});

it('assign session id when login is success', function () {
    $api = api()->login();

    expect($api->getSessionId())
        ->toBeString()
        ->toHaveLength(20);
});

it('throws an Exception when provide incorrect login', function () {
    expect(fn () => api('test')->login())
        ->toThrow(
            InvalidUserKey::class,
            'User key test is invalid'
        );
});

it('can logout', function () {
    $api = api()->login()->logout();

    expect($api)
        ->toBeTrue();
});

it('throws an Exception when session id is missing on logout', function () {
    expect(fn () => api()->logout())
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('returns true when logout on not existing session', function () {
    $api = api()->setSessionId('abc')->logout();

    expect($api)
        ->toBeTrue();
});

it('returns data status of service', function () {
    $api = api()->login()->dataStatus();

    expect($api)
        ->toBeInstanceOf(DateTimeInterface::class);
});

it('throws an Exception when not logged to get data status', function () {
    expect(fn () => api()->dataStatus())
        ->toThrow(
            IncorrectDataStatus::class,
            'Invalid date of data status.'
        );
});

it('returns message code of service', function () {
    $api = api()->login()->getMessageCode();

    expect($api)
        ->toBeInt()
        ->toBe(0);
});

it('throws an Exception when not logged for message code', function () {
    expect(fn () => api()->getMessageCode())
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('returns positive session status', function () {
    $api = api()->login()->getSessionStatus();

    expect($api)
        ->toBeBool()
        ->toBeTrue();
});

it('returns negative session status', function () {
    $api = api()->getSessionStatus();

    expect($api)
        ->toBeBool()
        ->toBeFalse();
});

it('returns service status', function () {
    $api = api()->getServiceStatus();

    expect($api)
        ->toBeInt()
        ->toBe(1);
});

it('returns service message', function () {
    $api = api()->getServiceMessage();

    expect($api)
        ->toBeString()
        ->toBe('Usluga dostepna');
});

it('returns entity by NIP', function () {
    $api = api()->login()->getByNip('5561007611');

    expect($api->result())
        ->toBeArray()
        ->toMatchArray([
            'Nip' => '5561007611',
            'Typ' => CompanyType::COMPANY,
        ]);
});

it('throws an Exception when not logged to get entity by NIP', function () {
    expect(fn () => api()->getByNip('5561007611'))
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('throws an Exception when not found entity by NIP', function () {
    expect(fn () => api()->login()->getByNip(' '))
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
        );
});

it('returns entity by KRS', function () {
    $api = api()->login()->getByKrs('0000496427');

    expect($api->result())
        ->toBeArray()
        ->toMatchArray([
            'Nip' => '5561007611',
            'Typ' => CompanyType::COMPANY,
        ]);
});

it('throws an Exception when not logged to get entity by KRS', function () {
    expect(fn () => api()->getByKrs('0000496427'))
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('throws an Exception when not found entity by KRS', function () {
    expect(fn () => api()->login()->getByKrs(' '))
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
        );
});

it('returns entity by REGON', function () {
    $api = api()->login()->getByRegon('091187826');

    expect($api->result())
        ->toBeArray()
        ->toMatchArray([
            'Nip' => '5561007611',
            'Regon' => '091187826',
            'Typ' => CompanyType::COMPANY,
        ]);
});

it('throws an Exception when not logged to get entity by REGON', function () {
    expect(fn () => api()->getByRegon('091187826'))
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('throws an Exception when not found entity by REGON', function () {
    expect(fn () => api()->login()->getByRegon(' '))
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
        );
});

it('returns many entities by multiple NIP', function () {
    $api = api()->login()->getByNips(['5561007611', '5260030236']);

    expect($api->result())
        ->toBeArray()
        ->toHaveCount(2)
        ->sequence(
            fn ($item) => $item->toMatchArray([
                'Nip' => '5561007611',
                'Typ' => CompanyType::COMPANY,
            ]),
            fn ($item) => $item->toMatchArray([
                'Nip' => '5260030236',
                'Typ' => CompanyType::COMPANY,
            ]),
        );
});

it('throws an Exception when not logged to get many entities by multiple NIP', function () {
    expect(fn () => api()->getByNips(['5561007611']))
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('throws an Exception when not found many entities by multiple NIP', function () {
    expect(fn () => api()->login()->getByNips([' ']))
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
        );
});

it('throws an Exception when not provided NIPs', function () {
    expect(fn () => api()->login()->getByNips([]))
        ->toThrow(
            LimitedIdentifiers::class,
            'Missing identifiers.'
        );
});

it('throws an Exception when provided too many NIPs', function () {
    expect(fn () => api()->login()->getByNips(range(0, 25)))
        ->toThrow(
            LimitedIdentifiers::class,
            'Too many identifiers. The maximum allowed is 20.'
        );
});

it('returns many entities by multiple KRS', function () {
    $api = api()->login()->getByKrses(['0000496427', '0000149371']);

    expect($api->result())
        ->toBeArray()
        ->toHaveCount(2)
        ->sequence(
            fn ($item) => $item->toMatchArray([
                'Nip' => '5561007611',
                'Typ' => CompanyType::COMPANY,
            ]),
            fn ($item) => $item->toMatchArray([
                'Nip' => '5260030236',
                'Typ' => CompanyType::COMPANY,
            ]),
        );
});

it('throws an Exception when not logged to get many entities by multiple KRS', function () {
    expect(fn () => api()->getByKrses(['0000496427']))
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('throws an Exception when not found many entities by multiple KRS', function () {
    expect(fn () => api()->login()->getByKrses([' ']))
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
        );
});

it('throws an Exception when not provided KRSs', function () {
    expect(fn () => api()->login()->getByKrses([]))
        ->toThrow(
            LimitedIdentifiers::class,
            'Missing identifiers.'
        );
});

it('throws an Exception when provided too many KRSs', function () {
    expect(fn () => api()->login()->getByKrses(range(0, 25)))
        ->toThrow(
            LimitedIdentifiers::class,
            'Too many identifiers. The maximum allowed is 20.'
        );
});

it('returns many entities by multiple REGON', function () {
    $api = api()->login()->getByRegons(['091187826', '010421047']);

    expect($api->result())
        ->toBeArray()
        ->toHaveCount(2)
        ->sequence(
            fn ($item) => $item->toMatchArray([
                'Nip' => '5561007611',
                'Regon' => '091187826',
                'Typ' => CompanyType::COMPANY,
            ]),
            fn ($item) => $item->toMatchArray([
                'Nip' => '5260030236',
                'Regon' => '010421047',
                'Typ' => CompanyType::COMPANY,
            ]),
        );
});

it('throws an Exception when not logged to get many entities by multiple REGON', function () {
    expect(fn () => api()->getByRegons(['0000496427']))
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('throws an Exception when not found many entities by multiple REGON', function () {
    expect(fn () => api()->login()->getByRegons([' ']))
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
        );
});

it('throws an Exception when not provided REGONs', function () {
    expect(fn () => api()->login()->getByRegons([]))
        ->toThrow(
            LimitedIdentifiers::class,
            'Missing identifiers.'
        );
});

it('throws an Exception when provided too many REGONs', function () {
    expect(fn () => api()->login()->getByRegons(range(0, 25)))
        ->toThrow(
            LimitedIdentifiers::class,
            'Too many identifiers. The maximum allowed is 20.'
        );
});

it('returns many entities by multiple REGON 14', function () {
    $api = api()->login()->getByRegons14(['00000002300041']);

    expect($api->result())
        ->toBeArray()
        ->toHaveCount(1)
        ->sequence(
            fn ($item) => $item->toMatchArray([
                'Nip' => '',
                'Regon' => '00000002300041',
                'Typ' => CompanyType::LOCAL_COMPANY,
            ]),
        );
});

it('throws an Exception when not logged to get many entities by multiple REGON 14', function () {
    expect(fn () => api()->getByRegons14(['0000496427']))
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('throws an Exception when not found many entities by multiple REGON 14', function () {
    expect(fn () => api()->login()->getByRegons14([' ']))
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
        );
});

it('throws an Exception when not provided REGONs 14', function () {
    expect(fn () => api()->login()->getByRegons14([]))
        ->toThrow(
            LimitedIdentifiers::class,
            'Missing identifiers.'
        );
});

it('throws an Exception when provided too many REGONs 14', function () {
    expect(fn () => api()->login()->getByRegons14(range(0, 25)))
        ->toThrow(
            LimitedIdentifiers::class,
            'Too many identifiers. The maximum allowed is 20.'
        );
});

it('returns full report about entity', function () {
    $api = api()->login()->getFullReport('091187826');

    expect($api)
        ->toBeInstanceOf(CompanyResponse::class)
        ->toHaveProperty('praw_regon9', '091187826');
});

it('returns full report about person entity', function () {
    $api = api()->login()->getFullReport('151482826');

    expect($api)
        ->toBeInstanceOf(PersonCompanyResponse::class)
        ->toHaveProperty('fiz_regon9', '151482826');
});

it('throws an Exception when not found any entity for full report', function () {
    expect(fn () => api()->login()->getFullReport(' '))
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono wpisu dla podanych kryteriów wyszukiwania.'
        );
});
