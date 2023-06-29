<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Responses;

use Exception;
use InvalidArgumentException;
use Rudashi\GusApi\Exceptions\NotFoundEntity;
use Rudashi\GusApi\Services\CompanyModel;
use SimpleXMLElement;

class SearchDataResponse implements ResponseInterface
{
    private bool $collect = false;

    public function __construct(
        private string $DaneSzukajPodmiotyResult,
        private SimpleXMLElement|null $xml = null,
    ) {
    }

    public function parseToXml(bool $toCollection = false): static
    {
        if ($this->DaneSzukajPodmiotyResult === '') {
            throw new NotFoundEntity('Entity not found.');
        }

        try {
            $this->xml = new SimpleXMLElement($this->DaneSzukajPodmiotyResult);
            $this->DaneSzukajPodmiotyResult = '';
            $this->collect = $toCollection;
        } catch (Exception $e) {
            throw new InvalidArgumentException('Invalid xml response', 0, $e);
        }

        return $this;
    }

    public function result(): Collection|CompanyModel
    {
        if ($this->isError($this->xml->dane)) {
            throw new NotFoundEntity((string) $this->xml->dane->ErrorMessagePl);
        }

        $collection = $this->toCollection();

        return $this->collect ? $collection : $collection->first();
    }

    public function toCollection(): Collection
    {
        if ($this->xml->count() > 1) {
            return Collection::each(
                fn ($item) => $this->toCompanyModel((array) $item),
                $this->asArray()['dane'],
            );
        }

        return new Collection([
            $this->toCompanyModel((array) $this->xml->dane)
        ]);
    }

    private function asArray(): array
    {
        return (array) $this->xml;
    }

    private function isError(SimpleXMLElement $xml): bool
    {
        return property_exists($xml, 'ErrorCode');
    }

    private function toCompanyModel(array $item): CompanyModel
    {
        return new CompanyModel(...array_map(static fn ($value) => (string) $value, $item));
    }
}
