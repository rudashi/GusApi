<?php

declare(strict_types=1);

namespace Rudashi\GusApi;

use Rudashi\GusApi\Contracts\Environment;
use Rudashi\GusApi\Contracts\Request;
use Rudashi\GusApi\Contracts\Response;
use Rudashi\GusApi\Enums\Action;
use Rudashi\GusApi\Requests\FullReportRequest;
use Rudashi\GusApi\Requests\GetValueRequest;
use Rudashi\GusApi\Requests\LoginRequest;
use Rudashi\GusApi\Requests\LogoutRequest;
use Rudashi\GusApi\Requests\SearchDataRequest;
use Rudashi\GusApi\Responses\FullReportResponse;
use Rudashi\GusApi\Responses\GetValueResponse;
use Rudashi\GusApi\Responses\LoginResponse;
use Rudashi\GusApi\Responses\LogoutResponse;
use Rudashi\GusApi\Responses\SearchDataResponse;
use Rudashi\GusApi\Services\Soap\Soap;
use Rudashi\GusApi\Services\Soap\SoapService;

class Client
{
    public const SERVICE = 'GUS';

    public function __construct(
        private readonly Environment $environment,
        private Soap|null $soap = null,
    ) {
    }

    public static function create(Environment $environment): self
    {
        return (new self($environment))->build();
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
            $this->soap->editService(
                name: self::SERVICE,
                closure: static fn (SoapService $service) => $service->setContextOptions([
                    'http' => [
                        'header' => 'sid: ' . $response->result(),
                    ],
                ])
            );
        }

        return $response;
    }

    public function logout(LogoutRequest $request): LogoutResponse
    {
        /** @var \Rudashi\GusApi\Responses\LogoutResponse $response */
        $response = $this->call(Action::LOGOUT, $request);

        return $response;
    }

    public function getValue(GetValueRequest $request): GetValueResponse
    {
        /** @var \Rudashi\GusApi\Responses\GetValueResponse $response */
        $response = $this->call(Action::GET_VALUE, $request);

        return $response;
    }

    public function searchEntity(SearchDataRequest $request, bool $collect = false): SearchDataResponse
    {
        /** @var \Rudashi\GusApi\Responses\SearchDataResponse $response */
        $response = $this->call(Action::SEARCH_DATA, $request);

        return $response->parseToXml($collect);
    }

    public function getFullReport(FullReportRequest $request): FullReportResponse
    {
        /** @var \Rudashi\GusApi\Responses\FullReportResponse $response */
        $response = $this->call(Action::FULL_REPORT, $request);

        return $response->parseToXml($request->report());
    }

    /**
     * @throws \SoapFault
     */
    protected function call(Action $action, Request $request): Response
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
