<?php

namespace Glsv\SbisApi\interfaces;

interface RequestInterface
{
    public function buildBody(): array;
}