<?php

namespace Glsv\SbisApi\interfaces;

interface DtoFactoryInterface
{
    static function create(array $data): object;
}