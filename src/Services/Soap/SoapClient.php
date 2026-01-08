<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\Soap;

use SoapClient as BaseClient;
use SoapFault;

class SoapClient extends BaseClient
{
    /**
     * @throws \SoapFault
     */
    public function __doRequest(
        string $request,
        string $location,
        string $action,
        int $version,
        bool $oneWay = false
    ): string {
        $response = parent::__doRequest($request, $location, $action, $version, $oneWay);

        if ($response === null) {
            throw new SoapFault('0', 'Empty response.');
        }

        $envelope = stristr($response, '<s:');

        if ($envelope === false) {
            throw new SoapFault('0', 'Invalid SOAP response format.');
        }

        $result = stristr($envelope, '</s:Envelope>', true);

        if ($result === false) {
            throw new SoapFault('0', 'Invalid SOAP envelope format.');
        }

        return $result . '</s:Envelope>';
    }

    /**
     * @param string $wsdl
     * @param array<string, mixed>|null $options
     * @param string|null $location
     */
    public static function new(string $wsdl, ?array $options = null, ?string $location = null): self
    {
        $client = new self($wsdl, $options ?? []);

        $client->__setLocation($location);

        return $client;
    }

    /**
     * @param array<string, mixed> $arguments
     * @param array<string, mixed>|null $options
     * @param array<string, \SoapHeader>|null $input_headers
     */
    public function call(string $name, array $arguments, ?array $options = null, ?array $input_headers = null): mixed
    {
        return $this->__soapCall($name, [$arguments], $options, $input_headers);
    }
}
