<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Requests;

use Rudashi\GusApi\Contracts\Request;
use Rudashi\GusApi\Enums\ReportName;
use Rudashi\GusApi\Enums\RequestParameter;

class FullReportRequest implements Request
{
    public function __construct(
        private readonly string $regon,
        private readonly ReportName $report,
    ) {
    }

    public function report(): ReportName
    {
        return $this->report;
    }

    public function toArray(): array
    {
        return [
            RequestParameter::REGON->value => $this->regon,
            RequestParameter::REPORT_NAME->value => $this->report->value,
        ];
    }
}
