<?php

namespace Kelaskakap\SaungwaPhp\Exceptions;

use RuntimeException;

class ApiException extends RuntimeException
{
    protected array $payload;

    public function __construct(string $message = "", int $code = 0, array $payload = [])
    {
        parent::__construct($message, $code);
        $this->payload = $payload;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }
}
