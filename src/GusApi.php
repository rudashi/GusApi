<?php

declare(strict_types=1);

namespace Rudashi\GusApi;

use DateTime;
use Rudashi\GusApi\Enums\Environment;
use Rudashi\GusApi\Enums\GetValue;
use Rudashi\GusApi\Enums\ReportName;
use Rudashi\GusApi\Exceptions\IncorrectDataStatus;
use Rudashi\GusApi\Exceptions\InvalidUserKey;
use Rudashi\GusApi\Exceptions\LimitedIdentifiers;
use Rudashi\GusApi\Exceptions\MissingSession;
use Rudashi\GusApi\Exceptions\NotFoundEntity;
use Rudashi\GusApi\Requests\FullReportRequest;
use Rudashi\GusApi\Requests\GetValueRequest;
use Rudashi\GusApi\Requests\LoginRequest;
use Rudashi\GusApi\Requests\LogoutRequest;
use Rudashi\GusApi\Requests\SearchDataRequest;
use Rudashi\GusApi\Responses\Collection;
use Rudashi\GusApi\Responses\CompanyResponse;
use Rudashi\GusApi\Responses\ResponseInterface;
use Rudashi\GusApi\Services\SearchParameters;

class GusApi
{
    protected const LIMIT_IDS = 20;
    private readonly Client $client;
    private string $sessionId;

    public function __construct(
        private readonly string $key,
        Environment $env = Environment::DEV,
    ) {
        $this->client = Client::create($env->service());
    }

    public function dataStatus(): DateTime
    {
        $result = $this->client->getValue(
            new GetValueRequest(GetValue::DATA_STATUS)
        )->result();

        $date = DateTime::createFromFormat('d-m-Y', $result);

        if ($date === false) {
            throw new IncorrectDataStatus('Invalid date of data status.');
        }

        return $date;
    }

    public function getMessageCode(): int
    {
        return (int) $this->authorize()->client->getValue(
            new GetValueRequest(GetValue::MESSAGE_CODE)
        )->result();
    }

    public function getServiceMessage(): string
    {
        return $this->client->getValue(
            new GetValueRequest(GetValue::SERVICE_MESSAGE)
        )->result();
    }

    public function getServiceStatus(): int
    {
        return (int) $this->client->getValue(
            new GetValueRequest(GetValue::SERVICE_STATUS)
        )->result();
    }

    public function getSessionId(): string
    {
        return $this->sessionId ?? throw new MissingSession('Session is not started.');
    }

    public function setSessionId(string $sessionId): static
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    public function getSessionStatus(): bool
    {
        if ($this->isLogged() === false) {
            return false;
        }

        return match ($this->authorize()->client->getValue(
            new GetValueRequest(GetValue::SESSION_STATUS)
        )->result()) {
            '0' => false,
            '1' => true,
            default => throw new IncorrectDataStatus('Invalid session status.'),
        };
    }

    public function isLogged(): bool
    {
        return isset($this->sessionId);
    }

    public function login(): GusApi
    {
        $response = $this->client->login(new LoginRequest($this->key));

        if ($response->isAuthorized() === false) {
            throw new InvalidUserKey(sprintf("User key %s is invalid", $this->key));
        }

        $this->setSessionId($response->result());

        return $this;
    }

    public function logout(): bool
    {
        return $this->client->logout(new LogoutRequest($this->getSessionId()))->result();
    }

    public function getByKrs(string $value): CompanyResponse
    {
        return new CompanyResponse(
            $this->authorize()->client->searchEntity(
                request: new SearchDataRequest(SearchParameters::krs($value))
            )->result()
        );
    }

    public function getByKrses(array $values): Collection
    {
        return $this->limit($values)->authorize()->client->searchEntity(
            request: new SearchDataRequest(SearchParameters::krsy($values)),
            collect: true
        )->result();
    }

    public function getByNip(string $value): CompanyResponse
    {
        return new CompanyResponse(
            $this->authorize()->client->searchEntity(
                request: new SearchDataRequest(SearchParameters::nip($value))
            )->result()
        );
    }

    public function getByNips(array $values): Collection
    {
        return $this->limit($values)->authorize()->client->searchEntity(
            request: new SearchDataRequest(SearchParameters::nipy($values)),
            collect: true
        )->result();
    }

    public function getByRegon(string $value): CompanyResponse
    {
        return new CompanyResponse(
            $this->authorize()->client->searchEntity(
                request: new SearchDataRequest(SearchParameters::regon($value))
            )->result()
        );
    }

    public function getByRegons(array $values): Collection
    {
        return $this->limit($values)->authorize()->client->searchEntity(
            request: new SearchDataRequest(SearchParameters::regony($values)),
            collect: true
        )->result();
    }

    public function getByRegons14(array $values): Collection
    {
        return $this->limit($values)->authorize()->client->searchEntity(
            request: new SearchDataRequest(SearchParameters::regony14($values)),
            collect: true
        )->result();
    }

    public function getFullReport(string $regon): ResponseInterface
    {
        try {
            return $this->authorize()->client->getFullReport(
                new FullReportRequest(
                    regon: $regon,
                    report: ReportName::COMPANY,
                )
            )->result();
        } catch (NotFoundEntity) {
            return $this->authorize()->client->getFullReport(
                new FullReportRequest(
                    regon: $regon,
                    report: ReportName::PERSON_CEIDG,
                )
            )->result();
        }
    }

    private function limit(array $values): static
    {
        $count = count($values);

        if ($count === 0) {
            throw new LimitedIdentifiers('Missing identifiers.');
        }

        if ($count > static::LIMIT_IDS) {
            throw new LimitedIdentifiers(sprintf("Too many identifiers. The maximum allowed is %d.", static::LIMIT_IDS));
        }

        return $this;
    }

    private function authorize(): static
    {
        $this->getSessionId();

        return $this;
    }
}
