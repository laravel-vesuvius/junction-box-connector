<?php

namespace App\Contracts;

interface ConnectorInterface
{

    /**
     * Implement authentication logic to connect to the third party
     * API
     */
    public function authenticate();

    /**
     * Set the authenticate header to support Guzzle client
     *
     * @return array
     */
    public function authHeaders(): array;

    /**
     * Send the request to the remote endpoint
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function doRequest();

    /**
     * Pull data out of the response from the endpoint
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getData(): array;

    /**
     * Generate the response property map
     *
     * e.g return ['FirstName' => $data['first_name'],...];
     * e.g return $data;
     *
     * @param $data
     * @return array
     */
    public function parse($data): array;

    /**
     * Set a unique key for this data collection for caching purposes
     *
     * @return string
     */
    public function getJobKey(): string;

    /**
     * Expose additional api methods if you are using a library
     * supplied by the vendor
     */
    public function getApi();
}
