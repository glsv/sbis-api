<?php

declare(strict_types=1);

namespace Glsv\SbisApi\interfaces;

use Glsv\SbisApi\dto\ApiErrorDataDto;

interface ApiResponseInterface
{
    public function isError(): bool;

    public function __toString(): string;

    public function getResult(): array;

    public function getError(): ?ApiErrorDataDto;
}