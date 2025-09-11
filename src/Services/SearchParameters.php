<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services;

readonly class SearchParameters
{
    public function __construct(
        private string|null $krs = null,
        private string|null $krsy = null,
        private string|null $nip = null,
        private string|null $nipy = null,
        private string|null $regon = null,
        private string|null $regony14 = null,
        private string|null $regony = null,
    ) {
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return array_filter([
            'Krs' => $this->krs,
            'Krsy' => $this->krsy,
            'Nip' => $this->nip,
            'Nipy' => $this->nipy,
            'Regon' => $this->regon,
            'Regony9zn' => $this->regony,
            'Regony14zn' => $this->regony14,
        ], static fn ($value) => $value !== null);
    }

    public static function krs(string $value): self
    {
        return new self(krs: $value);
    }

    /**
     * @param string|string[] $value
     */
    public static function krsy(string|array $value): self
    {
        return new self(krsy: static::parseValue($value));
    }

    public static function nip(string $value): self
    {
        return new self(nip: $value);
    }

    /**
     * @param string|string[] $value
     */
    public static function nipy(string|array $value): self
    {
        return new self(nipy: static::parseValue($value));
    }

    public static function regon(string $value): self
    {
        return new self(regon: $value);
    }

    /**
     * @param string|string[] $value
     */
    public static function regony(string|array $value): self
    {
        return new self(regony: static::parseValue($value));
    }

    /**
     * @param string|string[] $value
     */
    public static function regony14(string|array $value): self
    {
        return new self(regony14: static::parseValue($value));
    }

    /**
     * @param string|string[] $value
     */
    public static function parseValue(string|array $value): string
    {
        return is_array($value) ? implode(',', $value) : $value;
    }
}
