<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services\FullReport;

use Rudashi\GusApi\Responses\ResponseInterface;

/**
 * @phpstan-consistent-constructor
 */
class CompanyPKDResponse implements ResponseInterface
{
    public function __construct(
        public readonly string $pkdKod,
        public readonly string $pkdNazwa,
        public readonly string $pkdPrzewazajace,
    ) {
    }

    public function result(): array
    {
        return (array) $this;
    }

    public static function forCompany(
        string $praw_pkdKod,
        string $praw_pkdNazwa,
        string $praw_pkdPrzewazajace,
    ): static {
        return new static(
            pkdKod: $praw_pkdKod,
            pkdNazwa: $praw_pkdNazwa,
            pkdPrzewazajace: $praw_pkdPrzewazajace,
        );
    }

    public static function forLocalCompany(
        string $lokpraw_pkdKod,
        string $lokpraw_pkdNazwa,
        string $lokpraw_pkdPrzewazajace,
    ): static {
        return new static(
            pkdKod: $lokpraw_pkdKod,
            pkdNazwa: $lokpraw_pkdNazwa,
            pkdPrzewazajace: $lokpraw_pkdPrzewazajace,
        );
    }
}
