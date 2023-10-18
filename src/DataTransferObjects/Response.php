<?php

namespace MoolrePayments\DataTransferObjects;

class Response
{
    public function __construct(
        public readonly string $status,
        public readonly array  $data,
        public readonly string $message,
        public readonly ?array $errors = null,
    )
    {
    }
}