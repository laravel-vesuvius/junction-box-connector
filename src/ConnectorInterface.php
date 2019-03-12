<?php

namespace APN;

use GuzzleHttp\Psr7\Response;

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
     * Method is responsible for sending the request to the
     * remote endpoint and should return the entire response
     * object.
     *
     * @param string $endpoint
     * @param string $method
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(string $endpoint, string $method);

    /**
     * Method is responsible for extracting data out of a
     * response object.
     *
     * e.g return json_decode(
     *                $this->doRequest('endpoint', 'GET')
     *                ->getBody()
     *                ->getContents(), true)['item'];
     *
     * @param Response $data
     * @return array
     */
    public function getData(Response $data): array;

    /**
     * Method is responsible for transforming the data.
     *
     * e.g return ['FirstName' => $data['first_name'],...];
     * e.g return $data;
     *
     * @param $data
     * @return array
     */
    public function parse(array $data): array;

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
