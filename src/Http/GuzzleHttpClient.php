<?php

namespace Kelaskakap\SaungwaPhp\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Kelaskakap\SaungwaPhp\Contracts\HttpClientInterface;
use Kelaskakap\SaungwaPhp\Exceptions\ApiException;

class GuzzleHttpClient implements HttpClientInterface
{
    private Client $client;
    private string $baseUri;

    public function __construct(string $baseUri, array $options = [])
    {
        $this->baseUri = rtrim($baseUri, '/') . '/';
        $this->client = new Client(array_merge([
            'base_uri' => $this->baseUri,
            'timeout' => 30,
        ], $options));
    }

    public function post(string $uri, array $formParams = [], array $headers = []): array
    {
        try
        {
            $options = ['headers' => $headers];

            if (isset($formParams['__multipart']))
            {
                $options['multipart'] = $formParams['__multipart'];
            }
            else
            {
                $options['form_params'] = $formParams;
            }

            $response = $this->client->request('POST', ltrim($uri, '/'), $options);
        }
        catch (GuzzleException $e)
        {
            throw new ApiException('HTTP request failed: ' . $e->getMessage(), $e->getCode());
        }

        $body = (string) $response->getBody();
        $decoded = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE)
        {
            throw new ApiException('Invalid JSON response from API', $response->getStatusCode(), ['body' => $body]);
        }

        return $decoded;
    }
}
