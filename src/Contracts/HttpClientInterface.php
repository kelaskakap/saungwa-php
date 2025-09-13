<?php

namespace Kelaskakap\SaungwaPhp\Contracts;

interface HttpClientInterface
{
    /**
     * Send a POST request (form multipart or form-params)
     *
     * @param string $uri
     * @param array $formParams
     * @param array $headers
     * @return array Decoded JSON response as associative array
     */
    public function post(string $uri, array $formParams = [], array $headers = []): array;
}
