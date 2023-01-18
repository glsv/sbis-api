<?php

declare(strict_types=1);

namespace Glsv\SbisApi\vo;

use Glsv\SbisApi\exceptions\SbisInvalidParamsException;

class Currency
{
    private string $value;

    public function __construct(string $value)
    {
        if ($value === "") {
            throw new SbisInvalidParamsException('currency values is empty.');
        }

        $this->value = strtoupper($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}