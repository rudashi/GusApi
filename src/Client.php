<?php

declare(strict_types=1);

namespace Rudashi\GusApi;

use Rudashi\GusApi\Enums\Action;
use Rudashi\GusApi\Environment\EnvironmentInterface;
use Rudashi\GusApi\Requests\FullReportRequest;
use Rudashi\GusApi\Requests\GetValueRequest;
use Rudashi\GusApi\Requests\LoginRequest;
use Rudashi\GusApi\Requests\LogoutRequest;
use Rudashi\GusApi\Requests\RequestInterface;
use Rudashi\GusApi\Requests\SearchDataRequest;
use Rudashi\GusApi\Responses\FullReportResponse;
use Rudashi\GusApi\Responses\GetValueResponse;
use Rudashi\GusApi\Responses\LoginResponse;
use Rudashi\GusApi\Responses\LogoutResponse;
use Rudashi\GusApi\Responses\SearchDataResponse;
use Rudashi\GusApi\Services\Soap\Soap;
use Rudashi\GusApi\Services\Soap\SoapService;

/**
 * @phpstan-consistent-constructor
 */
class Client
{
    public const SERVICE = 'GUS';

    public function __construct(
        private readonly EnvironmentInterface $environment,
        private Soap|null $soap = null,
    ) {
    }

    public static function create(EnvironmentInterface $environment): static
    {
        return (new static($environment))->build();
    }

    public function build(): static
    {
        if ($this->soap) {
            return $this;
        }

        $this->soap = Soap::for(
            name: self::SERVICE,
            service: new SoapService(
                wsdl: $this->environment->wsdlUrl(),
                location: $this->environment->serviceUrl(),
                classMap: [
                    'ZalogujResponse' => LoginResponse::class,
                    'WylogujResponse' => LogoutResponse::class,
                    'GetValueResponse' => GetValueResponse::class,
                    'DaneSzukajPodmiotyResponse' => SearchDataResponse::class,
                    'DanePobierzPelnyRaportResponse' => FullReportResponse::class,
//                    'DanePobierzRaportZbiorczyResponse' => BulkReportResponse::class,
                ],
            )
        );

        return $this;
    }

    public function login(LoginRequest $request): LoginResponse
    {
        /** @var LoginResponse $response */
        $response = $this->call(Action::LOGIN, $request);

        if ($response->isAuthorized()) {
            $this->soap->editService(self::SERVICE, static function (SoapService $service) use ($response) {
                $service->setContextOptions([
                    'http' => [
                        'header' => 'sid: ' . $response->result(),
                    ],
                ]);
            });
        }

        return $response;
    }

    public function logout(LogoutRequest $request): LogoutResponse
    {
        return $this->call(Action::LOGOUT, $request);
    }

    public function getValue(GetValueRequest $request): GetValueResponse
    {
        return $this->call(Action::GET_VALUE, $request);
    }

    public function searchEntity(SearchDataRequest $request, bool $collect = false): SearchDataResponse
    {
        return $this->call(Action::SEARCH_DATA, $request)->parseToXml($collect);
    }

    public function getFullReport(FullReportRequest $request): FullReportResponse
    {
        return $this->call(Action::FULL_REPORT, $request)->parseToXml($request->report());
    }

    protected function call(Action $action, RequestInterface $request)
    {
        return $this->soap
            ->service(self::SERVICE)
            ->addHeader(
                name: 'To',
                namespace: 'http://www.w3.org/2005/08/addressing',
                data: $this->environment->serviceUrl(),
            )
            ->run(
                action: $action->service(),
                data: $request->toArray(),
            );
    }
}
