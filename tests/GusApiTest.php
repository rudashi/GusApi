<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Tests\GusApiTest;

use DateTime;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use Rudashi\GusApi\Contracts\Response;
use Rudashi\GusApi\Enums\CompanyType;
use Rudashi\GusApi\Exceptions\IncorrectDataStatus;
use Rudashi\GusApi\Exceptions\InvalidUserKey;
use Rudashi\GusApi\Exceptions\LimitedIdentifiers;
use Rudashi\GusApi\Exceptions\MissingSession;
use Rudashi\GusApi\Exceptions\NotFoundEntity;
use Rudashi\GusApi\GusApi;
use Rudashi\GusApi\Responses\Collection;
use Rudashi\GusApi\Services\CompanyModel;
use Rudashi\GusApi\Services\FullReport\CompanyResponse;
use Rudashi\GusApi\Services\FullReport\PersonCompanyResponse;

use function Rudashi\GusApi\Tests\api;

uses(TestCase::class);

it('can set session id', function (): void {
    $api = api()->setSessionId('abc');

    expect($api->getSessionId())
        ->toBe('abc');
});

it('throws an Exception when session not ', function (): void {
    expect(fn (): string => api()->getSessionId())
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('pass when session is started', function (): void {
    $api = api()->setSessionId('abc')->isLogged();

    expect($api)
        ->toBeTrue();
});

it('fails when session is not started', function (): void {
    $api = api()->isLogged();

    expect($api)
        ->toBeFalse();
});

it('assign session id when login is success', function (): void {
    $api = api()->login();

    expect($api->getSessionId())
        ->toBeString()
        ->toHaveLength(20);
});

it('throws an Exception when provide incorrect login', function (): void {
    expect(fn (): GusApi => api('test')->login())
        ->toThrow(
            InvalidUserKey::class,
            'User key test is invalid'
        );
});

it('can logout', function (): void {
    $api = api()->login()->logout();

    expect($api)
        ->toBeTrue();
});

it('throws an Exception when session id is missing on logout', function (): void {
    expect(fn (): bool => api()->logout())
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('returns true when logout on not existing session', function (): void {
    $api = api()->setSessionId('abc')->logout();

    expect($api)
        ->toBeTrue();
});

it('returns data status of service', function (): void {
    $api = api()->login()->dataStatus();

    expect($api)
        ->toBeInstanceOf(DateTimeInterface::class);
});

it('throws an Exception when not logged to get data status', function (): void {
    expect(fn (): DateTime => api()->dataStatus())
        ->toThrow(
            IncorrectDataStatus::class,
            'Invalid date of data status.'
        );
});

it('returns message code of service', function (): void {
    $api = api()->login()->getMessageCode();

    expect($api)
        ->toBeInt()
        ->toBe(0);
});

it('throws an Exception when not logged for message code', function (): void {
    expect(fn (): int => api()->getMessageCode())
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('returns positive session status', function (): void {
    $api = api()->login()->getSessionStatus();

    expect($api)
        ->toBeBool()
        ->toBeTrue();
});

it('returns negative session status', function (): void {
    $api = api()->getSessionStatus();

    expect($api)
        ->toBeBool()
        ->toBeFalse();
});

it('returns service status', function (): void {
    $api = api()->getServiceStatus();

    expect($api)
        ->toBeInt()
        ->toBe(1);
});

it('returns service message', function (): void {
    $api = api()->getServiceMessage();

    expect($api)
        ->toBeString()
        ->toBe('Usluga dostepna');
});

it('returns entity by NIP', function (): void {
    $api = api()->login()->getByNip('5561007611');

    expect($api->result())
        ->toBeInstanceOf(CompanyModel::class)
        ->toMatchArray([
            'Nip' => '5561007611',
            'Typ' => CompanyType::COMPANY,
        ]);
});

it('throws an Exception when not logged to get entity by NIP', function (): void {
    expect(fn (): Response => api()->getByNip('5561007611'))
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('throws an Exception when not found entity by NIP', function (): void {
    expect(fn (): Response => api()->login()->getByNip(' '))
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
        );
});

it('returns entity by KRS', function (): void {
    $api = api()->login()->getByKrs('0000496427');

    expect($api->result())
        ->toBeInstanceOf(CompanyModel::class)
        ->toMatchArray([
            'Nip' => '5561007611',
            'Typ' => CompanyType::COMPANY,
        ]);
});

it('throws an Exception when not logged to get entity by KRS', function (): void {
    expect(fn (): Response => api()->getByKrs('0000496427'))
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('throws an Exception when not found entity by KRS', function (): void {
    expect(fn (): Response => api()->login()->getByKrs(' '))
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
        );
});

it('returns entity by REGON', function (): void {
    $api = api()->login()->getByRegon('091187826');

    expect($api->result())
        ->toBeInstanceOf(CompanyModel::class)
        ->toMatchArray([
            'Nip' => '5561007611',
            'Regon' => '091187826',
            'Typ' => CompanyType::COMPANY,
        ]);
});

it('throws an Exception when not logged to get entity by REGON', function (): void {
    expect(fn (): Response => api()->getByRegon('091187826'))
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('throws an Exception when not found entity by REGON', function (): void {
    expect(fn (): Response => api()->login()->getByRegon(' '))
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
        );
});

it('returns many entities by multiple NIP', function (): void {
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

it('throws an Exception when not logged to get many entities by multiple NIP', function (): void {
    expect(fn (): Collection => api()->getByNips(['5561007611']))
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('throws an Exception when not found many entities by multiple NIP', function (): void {
    expect(fn (): Collection => api()->login()->getByNips([' ']))
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
        );
});

it('throws an Exception when not provided NIPs', function (): void {
    expect(fn (): Collection => api()->login()->getByNips([]))
        ->toThrow(
            LimitedIdentifiers::class,
            'Missing identifiers.'
        );
});

it('throws an Exception when provided too many NIPs', function (): void {
    expect(fn (): Collection => api()->login()->getByNips(range(0, 25)))
        ->toThrow(
            LimitedIdentifiers::class,
            'Too many identifiers. The maximum allowed is 20.'
        );
});

it('returns many entities by multiple KRS', function (): void {
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

it('throws an Exception when not logged to get many entities by multiple KRS', function (): void {
    expect(fn (): Collection => api()->getByKrses(['0000496427']))
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('throws an Exception when not found many entities by multiple KRS', function (): void {
    expect(fn (): Collection => api()->login()->getByKrses([' ']))
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
        );
});

it('throws an Exception when not provided KRSs', function (): void {
    expect(fn (): Collection => api()->login()->getByKrses([]))
        ->toThrow(
            LimitedIdentifiers::class,
            'Missing identifiers.'
        );
});

it('throws an Exception when provided too many KRSs', function (): void {
    expect(fn (): Collection => api()->login()->getByKrses(range(0, 25)))
        ->toThrow(
            LimitedIdentifiers::class,
            'Too many identifiers. The maximum allowed is 20.'
        );
});

it('returns many entities by multiple REGON', function (): void {
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

it('throws an Exception when not logged to get many entities by multiple REGON', function (): void {
    expect(fn (): Collection => api()->getByRegons(['0000496427']))
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('throws an Exception when not found many entities by multiple REGON', function (): void {
    expect(fn (): Collection => api()->login()->getByRegons([' ']))
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
        );
});

it('throws an Exception when not provided REGONs', function (): void {
    expect(fn (): Collection => api()->login()->getByRegons([]))
        ->toThrow(
            LimitedIdentifiers::class,
            'Missing identifiers.'
        );
});

it('throws an Exception when provided too many REGONs', function (): void {
    expect(fn (): Collection => api()->login()->getByRegons(range(0, 25)))
        ->toThrow(
            LimitedIdentifiers::class,
            'Too many identifiers. The maximum allowed is 20.'
        );
});

it('returns many entities by multiple REGON 14', function (): void {
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

it('throws an Exception when not logged to get many entities by multiple REGON 14', function (): void {
    expect(fn (): Collection => api()->getByRegons14(['0000496427']))
        ->toThrow(
            MissingSession::class,
            'Session is not started.'
        );
});

it('throws an Exception when not found many entities by multiple REGON 14', function (): void {
    expect(fn (): Collection => api()->login()->getByRegons14([' ']))
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono podmiotu dla podanych kryteriów wyszukiwania.'
        );
});

it('throws an Exception when not provided REGONs 14', function (): void {
    expect(fn (): Collection => api()->login()->getByRegons14([]))
        ->toThrow(
            LimitedIdentifiers::class,
            'Missing identifiers.'
        );
});

it('throws an Exception when provided too many REGONs 14', function (): void {
    expect(fn (): Collection => api()->login()->getByRegons14(range(0, 25)))
        ->toThrow(
            LimitedIdentifiers::class,
            'Too many identifiers. The maximum allowed is 20.'
        );
});

it('returns full report about entity', function (): void {
    $api = api()->login()->getFullReport('091187826');

    expect($api)
        ->toBeInstanceOf(CompanyResponse::class)
        ->toHaveProperty('praw_regon9', '091187826');
});

it('returns full report about person entity', function (): void {
    $api = api()->login()->getFullReport('151482826');

    expect($api)
        ->toBeInstanceOf(PersonCompanyResponse::class)
        ->toHaveProperty('fiz_regon9', '151482826');
});

it('throws an Exception when not found any entity for full report', function (): void {
    expect(fn (): Response => api()->login()->getFullReport(' '))
        ->toThrow(
            NotFoundEntity::class,
            'Nie znaleziono wpisu dla podanych kryteriów wyszukiwania.'
        );
});
