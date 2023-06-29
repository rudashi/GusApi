<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\Soap;

use Closure;
use Rudashi\GusApi\Exceptions\SoapServiceAlreadyExists;
use Rudashi\GusApi\Exceptions\SoapServiceNotExists;

class Soap
{
    /**
     * @var array|SoapService[]
     */
    protected array $services = [];

    public static function for(string $name, SoapService $service): static
    {
        return (new static())->addService($name, $service);
    }

    public function addService(string $name, SoapService $service): static
    {
        if ($this->hasService($name) === false) {
            $this->services[$name] = $service;

            return $this;
        }

        throw new SoapServiceAlreadyExists(sprintf("Service %s already exists.", $name));
    }

    public function editService(string $name, Closure $closure): Soap
    {
        $closure($this->service($name));

        return $this;
    }

    public function hasService(string $name): bool
    {
        return array_key_exists($name, $this->services);
    }

    public function service(string $name): SoapService
    {
        if ($this->hasService($name) === false) {
            throw new SoapServiceNotExists(sprintf("Service %s not exists.", $name));
        }

        return $this->services[$name];
    }
}
