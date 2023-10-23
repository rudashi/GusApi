<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\Soap;

use SoapClient as BaseClient;
use SoapFault;

class SoapClient extends BaseClient
{
    public function __doRequest(
        string $request,
        string $location,
        string $action,
        int $version,
        $oneWay = false
    ): string {
        $response = parent::__doRequest($request, $location, $action, $version, $oneWay);

        if ($response === null) {
            throw new SoapFault('0', 'Empty response.');
        }

        return stristr(stristr($response, '<s:'), '</s:Envelope>', true) . '</s:Envelope>';
    }

    public static function new(
        string $wsdl,
        array|null $options = null,
        string|null $location = null,
        array $headers = []
    ): self {
        $client = new self($wsdl, $options);

        $client->__setSoapHeaders($headers);
        $client->__setLocation($location);

        return $client;
    }

    public function call(
        string $function_name,
        array $arguments,
        array|null $options = null,
        array|null $input_headers = null,
        array|null &$output_headers = null
    ) {
        return $this->__soapCall($function_name, [$arguments], $options, $input_headers, $output_headers);
    }
}
