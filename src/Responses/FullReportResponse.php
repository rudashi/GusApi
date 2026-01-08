<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Responses;

use Exception;
use InvalidArgumentException;
use Rudashi\GusApi\Contracts\Response;
use Rudashi\GusApi\Enums\ReportName;
use Rudashi\GusApi\Exceptions\NotFoundEntity;
use SimpleXMLElement;

class FullReportResponse implements Response
{
    private SimpleXMLElement $xml;

    public function __construct(
        private string $DanePobierzPelnyRaportResult,
        private ReportName $report,
    ) {
    }

    public function parseToXml(ReportName $report): static
    {
        if ($this->DanePobierzPelnyRaportResult === '') {
            throw new NotFoundEntity('Entity not found.');
        }

        try {
            $this->report = $report;
            $this->xml = new SimpleXMLElement($this->DanePobierzPelnyRaportResult);
            $this->DanePobierzPelnyRaportResult = '';
        } catch (Exception $e) {
            throw new InvalidArgumentException('Invalid xml response', 0, $e);
        }

        return $this;
    }

    public function result(): Response
    {
        if ($this->isError($this->xml->dane)) {
            throw new NotFoundEntity((string) $this->xml->dane->ErrorMessagePl);
        }

        /** @var array{dane: \SimpleXMLElement|iterable<\SimpleXMLElement>} $xmlArray */
        $xmlArray = (array) $this->xml;

        return $this->report->toResponse($xmlArray);
    }

    private function isError(SimpleXMLElement $xml): bool
    {
        return property_exists($xml, 'ErrorCode');
    }
}
