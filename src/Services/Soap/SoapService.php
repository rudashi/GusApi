<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\Soap;

use SoapHeader;

class SoapService
{
    protected string $wsdl;
    protected SoapClient|null $client = null;
    protected array $options = [
        'soap_version' => SOAP_1_2,
        'trace' => true,
        'style' => SOAP_DOCUMENT,
        'exceptions' => false,
        'local_cert' => false,
        'cache_wsdl' => WSDL_CACHE_NONE,
        'stream_context' => null,
        'classmap' => [],
    ];
    protected array $headers = [];
    protected string $location;

    public function __construct(string $wsdl, string $location, array $classMap)
    {
        $this->options['classmap'] = $classMap;
        $this->location = $location;
        $this->wsdl = $wsdl;
    }

    public function addClient(SoapClient $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function addHeader(string $name, string $namespace, mixed $data = null): static
    {
        $this->headers[$name] = new SoapHeader($namespace, $name, $data);

        return $this;
    }

    public function run(SoapCallInterface $action, array $data, array $options = [], array $headers = [])
    {
        if ($this->client === null) {
            $this->addClient(SoapClient::new(
                $this->wsdl,
                $this->getOptions(),
                $this->location,
            ));
        }

        return $this->client->call(
            function_name: $action->functionName(),
            arguments: $data,
            options: $options,
            input_headers: [
                ...$this->headers,
                ...$action->headers(),
                ...$headers,
            ],
        );
    }

    public function getOptions(): array
    {
        $this->options['stream_context'] = stream_context_create();

        return $this->options;
    }

    public function setContextOptions(array $options): static
    {
        $this->options['stream_context'] = stream_context_set_option($this->options['stream_context'], $options);

        return $this;
    }
}
