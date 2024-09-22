<?php
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Guzzlelib
{
    private $client;
    private $base_url = null;
    private $defaultHeaders = [
        'Content-Type' => 'application/json',
        'Accept'       => 'application/json',
    ];

    public function __construct($config = [])
    {
        $this->client = $this->initializeGuzzle($config);
    }

    // Function for GET requests
    public function getRequest($endpoint, $queryParams = [], $headers = [])
    {
        return $this->sendRequest('GET', $endpoint, [
            'query' => $queryParams,
            'headers' => $this->setHeaders($headers),
        ]);
    }

    // Function for POST requests
    public function postRequest($endpoint, $body = [], $headers = [])
    {
        return $this->sendRequest('POST', $endpoint, [
            'json' => $body,
            'headers' => $this->setHeaders($headers),
        ]);
    }

    // Function for PUT requests
    public function putRequest($endpoint, $body = [], $headers = [])
    {
        return $this->sendRequest('PUT', $endpoint, [
            'json' => $body,
            'headers' => $this->setHeaders($headers),
        ]);
    }

    // Function for PATCH requests
    public function patchRequest($endpoint, $body = [], $headers = [])
    {
        return $this->sendRequest('PATCH', $endpoint, [
            'json' => $body,
            'headers' => $this->setHeaders($headers),
        ]);
    }

    // Function for DELETE requests
    public function deleteRequest($endpoint, $body = [], $headers = [])
    {
        $options = !empty($body) ? ['json' => $body] : [];
        $options['headers'] = $this->setHeaders($headers);
        return $this->sendRequest('DELETE', $endpoint, $options);
    }

    // Centralized method to send requests
    private function sendRequest($method, $endpoint, array $options = [])
    {
        try {
            $response = $this->client->request($method, $this->base_url . $endpoint, $options);

            // Get the response status code
            $statusCode = $response->getStatusCode();

            // Decode the response body
            $body = json_decode($response->getBody()->getContents(), true);

            // Return an array with status code and body
            return [
                'code' => $statusCode,
                'body' => $body
            ];
        } catch (RequestException $e) {
            return $this->handleRequestException($e);
        }
    }

    // Function to merge default and custom headers
    private function setHeaders($customHeaders)
    {
        return array_merge($this->defaultHeaders, $customHeaders);
    }

    // Function to merge default and custom base_url
    private function setBaseUrl($customURL =  null)
    {
        return $customURL ?? $this->base_url;
    }

    // Function to handle different types of errors
    private function handleRequestException(RequestException $e)
    {
        if ($e->hasResponse()) {
            $errorBody = $e->getResponse()->getBody()->getContents();
            return json_decode($errorBody, true);
        } else {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    private function initializeGuzzle($config = [])
    {
        $this->defaultHeaders = $this->setHeaders($config['headers'] ?? []);
        $this->base_url = $this->setBaseUrl($config['base_uri'] ?? null);
        return new Client([
            'base_uri'        => $this->base_url,
            'timeout'         => $config['timeout'] ?? 10.0,
            'headers'         => $this->defaultHeaders,
            'auth'            => $config['auth'] ?? null,
            'proxy'           => $config['proxy'] ?? null,
            'verify'          => $config['verify'] ?? true,
            'connect_timeout' => $config['connect_timeout'] ?? null,
            'cookies'         => $config['cookies'] ?? null,
            'allow_redirects' => $config['allow_redirects'] ?? true,
            'debug'           => $config['debug'] ?? false,
            'http_errors'     => $config['http_errors'] ?? true,
        ]);
    }
}
