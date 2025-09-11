<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\FullReport;

use Rudashi\GusApi\Contracts\Response;

readonly class CompanyPKDResponse implements Response
{
    public function __construct(
        public string $pkdKod,
        public string $pkdNazwa,
        public string $pkdPrzewazajace,
    ) {
    }

    /**
     * @return array<string, string>
     */
    public function result(): array
    {
        return (array) $this;
    }

    public static function forCompany(
        string $praw_pkdKod,
        string $praw_pkdNazwa,
        string $praw_pkdPrzewazajace,
    ): self {
        return new self(
            pkdKod: $praw_pkdKod,
            pkdNazwa: $praw_pkdNazwa,
            pkdPrzewazajace: $praw_pkdPrzewazajace,
        );
    }

    public static function forLocalCompany(
        string $lokpraw_pkdKod,
        string $lokpraw_pkdNazwa,
        string $lokpraw_pkdPrzewazajace,
    ): self {
        return new self(
            pkdKod: $lokpraw_pkdKod,
            pkdNazwa: $lokpraw_pkdNazwa,
            pkdPrzewazajace: $lokpraw_pkdPrzewazajace,
        );
    }
}
