<?php

declare(strict_types=1);

namespace Glsv\SbisApi\exceptions;

class SbisApiUnauthorizedException extends SbisApiException
{
    public $code = 401;
}