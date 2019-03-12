<?php

namespace APN\FreshSales;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class FreshSales implements ConnectorInterface
{
    protected $apiKey;
    protected $apiBaseUrl;
    /** @var Client */
    protected $client;

    public function __construct(string $apiKey, string $domain)
    {
        $this->apiKey = $apiKey;
        $this->apiBaseUrl = "https://'{$domain}.freshsales.io/api/";
        $this->client = new Client();
    }

    /**
     * @return void
     */
    public function authenticate()
    {
        $this->client = $this->createClientWithHeaders($this->authHeaders());
    }

    /**
     * @param array $headers
     * @return Client
     */
    protected function createClientWithHeaders(array $headers)
    {
        return new Client([
            'headers' => $headers
        ]);
    }

    /**
     * Set the authenticate header to support Guzzle client
     *
     * @return array
     */
    public function authHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => "Token token={$this->apiKey}"
        ];
    }

    /**
     * Method is responsible for extracting data out of a
     * response object.
     *
     * @param Response $response
     * @return array
     */
    public function getData(Response $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Method is responsible for extracting data without meta
     * out of a response object
     *
     * @param Response $response
     * @return array
     */
    public function getBulkData(Response $response): array
    {
        $responseData = json_decode($response->getBody()->getContents(), true);
        unset($responseData['meta']);
        return $responseData;
    }

    /**
     * Method is responsible for sending the request to the
     * remote endpoint and should return the entire response
     * object.
     *
     * @param string $endpoint
     * @param string $method
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(string $endpoint, string $method): Response
    {
        $request = new Request($method, $this->apiBaseUrl . $endpoint);
        return $this->client->send($request);
    }

    /**
     * Method is responsible for transforming the data.
     *
     * @param array $items
     * @return array
     */
    public function parse(array $items): array
    {
        return array_map([$this, 'parseItem'], $items);
    }

    /**
     * @param array $item
     * @return array
     */
    public function parseItem(array $item): array
    {
        return [
            'full_name' => "{$item['first_name']} {$item['last_name']}",
            'company' => $item['company']['name'],
            'email' => $item['email'],
            'phone' => $item['mobile_number'],
            'address' => "{$item['address']} {$item['city']} {$item['state']} {$item['zipcode']}",
        ];
    }

    /**
     * Set a unique key for this data collection for caching purposes
     *
     * @return string
     */
    public function getJobKey(): string
    {
        // TODO: Implement getJobKey() method.
    }

    /**
     * Expose additional api methods if you are using a library
     * supplied by the vendor
     */
    public function getApi()
    {
        // TODO: Implement getApi() method.
    }
}
