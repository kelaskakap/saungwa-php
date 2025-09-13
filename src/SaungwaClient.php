<?php

namespace Kelaskakap\SaungwaPhp;

use Kelaskakap\SaungwaPhp\Contracts\HttpClientInterface;
use Kelaskakap\SaungwaPhp\Exceptions\ApiException;
use Kelaskakap\SaungwaPhp\Exceptions\AuthenticationException;

final class SaungwaClient
{
    private Config $config;
    private HttpClientInterface $http;

    public function __construct(Config $config, HttpClientInterface $httpClient)
    {
        $this->config = $config;
        $this->http = $httpClient;
    }

    /**
     * Create message (text, file, or template) as per Saungwa API
     *
     * $payload keys:
     * - to (string, required)
     * - message (string)
     * - template_id (string)
     * - file (string) -> URL to file
     * - variables (array)
     * - sandbox (bool)
     */
    public function createMessage(array $payload): array
    {
        $endpoint = '/create-message';

        // base required keys
        $form = [
            'appkey' => $this->config->getAppKey(),
            'authkey' => $this->config->getAuthKey(),
            'sandbox' => $this->config->isSandbox() ? 'true' : 'false',
        ];

        // merge with payload (user provided)
        $form = array_merge($form, $payload);

        // sanitize: ensure 'to' exists
        if (empty($form['to']))
        {
            throw new ApiException("Field 'to' is required");
        }

        // Decide whether to use multipart (for file URL or file upload)
        $useMultipart = false;
        if (isset($form['file']))
        {
            // API sample uses form-data; detect and use multipart
            $useMultipart = true;
        }

        if ($useMultipart)
        {
            // Build multipart array: form fields
            $multipart = [];
            foreach ($form as $name => $value)
            {
                if ($name === 'variables' && is_array($value))
                {
                    // Saungwa expects variables[{key}] style; send as JSON string or flattened form-data keys
                    foreach ($value as $k => $v)
                    {
                        $multipart[] = [
                            'name' => "variables[$k]",
                            'contents' => (string)$v,
                        ];
                    }
                    continue;
                }
                // If value is array convert to JSON string
                $multipart[] = [
                    'name' => $name,
                    'contents' => is_array($value) ? json_encode($value) : (string)$value,
                ];
            }

            // call http client - but our HttpClientInterface has generic post; we rely on Http implementation to support 'multipart' conventions
            // To keep interface simple, we pass a special key "__multipart" that custom adapter understands.
            return $this->http->post($endpoint, ['__multipart' => $multipart]);
        }

        // normal form params
        $response = $this->http->post($endpoint, $form);

        // basic success check
        if (!isset($response['message_status']) || strtolower($response['message_status']) !== 'success')
        {
            // if status code present in data, use it
            if (isset($response['data']['status_code']) && $response['data']['status_code'] == 401)
            {
                throw new AuthenticationException('Authentication failed', 401, $response);
            }
            throw new ApiException('API returned error', $response['data']['status_code'] ?? 0, $response);
        }

        return $response;
    }
}
