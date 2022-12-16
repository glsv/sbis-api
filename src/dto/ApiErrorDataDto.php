<?php

declare(strict_types=1);

namespace Glsv\SbisApi\dto;

class ApiErrorDataDto
{
    public int $code;
    public string $message;
    public ?string $details;
    public ?string $type;
    public ?array $data;

    public static function create(array $rawData): self
    {
        $m = new self;
        $m->code = $rawData['code'] ?? null;
        $m->message = $rawData['message'] ?? null;
        $m->details = $rawData['details'] ?? null;
        $m->type = $rawData['type'] ?? null;
        $m->data = $rawData['data'] ?? null;

        return $m;
    }

    public function __toString(): string
    {
        $attrs = [
            'code',
            'message',
            'details',
            'type',
        ];

        $str = "\n";

        foreach ($attrs as $attr) {
            if ($this->$attr) {
                $str .= ucfirst($attr) . ': ' . $this->$attr . "\n";
            }
        }

        if ($this->data) {
            $str .= 'Data: ' . json_encode($this->data) . "\n";
        }

        return $str;
    }
}