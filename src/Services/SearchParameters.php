<?php

declare(strict_types=1);

namespace Rudashi\GusApi\Services;

/**
 * @phpstan-consistent-constructor
 */
class SearchParameters
{
    public function __construct(
        private readonly string|null $krs = null,
        private readonly string|null $krsy = null,
        private readonly string|null $nip = null,
        private readonly string|null $nipy = null,
        private readonly string|null $regon = null,
        private readonly string|null $regony14 = null,
        private readonly string|null $regony = null,
    ) {
    }

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

    public static function krs(string $value): static
    {
        return new static(krs: $value);
    }

    public static function krsy(string|array $value): static
    {
        return new static(krsy: static::parseValue($value));
    }

    public static function nip(string $value): static
    {
        return new static(nip: $value);
    }

    public static function nipy(string|array $value): static
    {
        return new static(nipy: static::parseValue($value));
    }

    public static function regon(string $value): static
    {
        return new static(regon: $value);
    }

    public static function regony(string|array $value): static
    {
        return new static(regony: static::parseValue($value));
    }

    public static function regony14(string|array $value): static
    {
        return new static(regony14: static::parseValue($value));
    }

    public static function parseValue(string|array $value): string
    {
        return is_array($value) ? implode(',', $value) : $value;
    }
}
