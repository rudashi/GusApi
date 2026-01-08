<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Responses;

use Exception;
use InvalidArgumentException;
use Rudashi\GusApi\Contracts\Response;
use Rudashi\GusApi\Exceptions\NotFoundEntity;
use Rudashi\GusApi\Services\CompanyModel;
use SimpleXMLElement;

class SearchDataResponse implements Response
{
    private SimpleXMLElement $xml;

    public function __construct(
        private string $DaneSzukajPodmiotyResult,
    ) {
    }

    public function parseToXml(): static
    {
        if ($this->DaneSzukajPodmiotyResult === '') {
            throw new NotFoundEntity('Entity not found.');
        }

        try {
            $this->xml = new SimpleXMLElement($this->DaneSzukajPodmiotyResult);
            $this->DaneSzukajPodmiotyResult = '';
        } catch (Exception $e) {
            throw new InvalidArgumentException('Invalid xml response', 0, $e);
        }

        return $this;
    }

    /**
     * @return \Rudashi\GusApi\Responses\Collection<int, \Rudashi\GusApi\Services\CompanyModel>
     */
    public function result(): Collection
    {
        if ($this->isError($this->xml->dane)) {
            throw new NotFoundEntity((string) $this->xml->dane->ErrorMessagePl);
        }

        return $this->toCollection();
    }

    public function resultOne(): CompanyModel
    {
        return $this->result()->first();
    }

    /**
     * @return \Rudashi\GusApi\Responses\Collection<int, \Rudashi\GusApi\Services\CompanyModel>
     */
    public function toCollection(): Collection
    {
        if ($this->xml->count() > 1) {
            return Collection::each(
                fn ($item) => $this->toCompanyModel((array) $item),
                $this->asArray()['dane'],
            );
        }

        return new Collection([
            $this->toCompanyModel((array) $this->xml->dane),
        ]);
    }

    /**
     * @return array{dane: array<int, \SimpleXMLElement>}
     */
    private function asArray(): array
    {
        /** @var array{dane: array<int, \SimpleXMLElement>} $array */
        $array = (array) $this->xml;

        return $array;
    }

    private function isError(SimpleXMLElement $xml): bool
    {
        return property_exists($xml, 'ErrorCode');
    }

    /**
     * @param array<string, string|\SimpleXMLElement> $item
     */
    private function toCompanyModel(array $item): CompanyModel
    {
        return new CompanyModel(...array_map(static fn ($value) => (string) $value, $item));
    }
}
