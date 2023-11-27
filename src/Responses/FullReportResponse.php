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
    public function __construct(
        private string $DanePobierzPelnyRaportResult,
        private ReportName $report,
        private SimpleXMLElement|null $xml = null,
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

        return $this->report->toResponse((array) $this->xml);
    }

    private function isError(SimpleXMLElement $xml): bool
    {
        return property_exists($xml, 'ErrorCode');
    }
}
