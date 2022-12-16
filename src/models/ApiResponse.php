<?php

declare(strict_types=1);

namespace Glsv\SbisApi\models;

use Glsv\SbisApi\dto\ApiErrorDataDto;
use Glsv\SbisApi\interfaces\ApiResponseInterface;

class ApiResponse implements ApiResponseInterface
{
    protected $jsonrpc;
    protected ?int $id = null;
    protected int $protocol;

    protected ?ApiErrorDataDto $error = null;

    protected array $result = [];

    public static function create(array $rawData): static
    {
        $m = new static();
        $m->initCommonAttrs($rawData);

        if (isset($rawData['error'])) {
            $m->error = ApiErrorDataDto::create($rawData['error']);
        } else {
            $m->result = $rawData['result'] ?? [];
        }

        return $m;
    }

    protected function initCommonAttrs(array $rawData)
    {
        $this->jsonrpc = $rawData['jsonrpc'] ?? null;
        $this->id = $rawData['id'] ?? null;
        $this->protocol = $rawData['protocol'] ?? null;
    }

    public function isError(): bool
    {
        return $this->error !== null;
    }

    public function __toString(): string
    {
        if ($this->isError()) {
            return (string)$this->error;
        }

        return json_encode($this->result);
    }

    public function getResult(): array
    {
        return $this->result;
    }

    public function getError(): ?ApiErrorDataDto
    {
        return $this->error;
    }
}