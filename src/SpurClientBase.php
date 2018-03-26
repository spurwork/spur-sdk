<?php

namespace Spur;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

abstract class SpurClientBase
{
    protected $baseUrl;
    protected $authToken;

    public function __construct($baseUrl, $authToken)
    {
        $this->baseUrl = $baseUrl;
        $this->authToken = $authToken;
    }

    public function get($url, $queryParams = [])
    {
        return $this->send('GET', $url, [
            'query' => $queryParams,
        ]);
    }

    public function post($url, $params = [])
    {
        return $this->send('POST', $url, [
            'json' => $params,
        ]);
    }

    public function patch($url, $params = [])
    {
        return $this->send('PATCH', $url, [
            'json' => $params,
        ]);
    }

    public function put($url, $params = [])
    {
        return $this->send('PUT', $url, [
            'json' => $params,
        ]);
    }

    public function delete($url, $params = [])
    {
        return $this->send('DELETE', $url, [
            'json' => $params,
        ]);
    }

    public function send($method, $url, $options)
    {
        try {
            return json_decode($this->getClient()->request($method, $url, $options)->getBody()->getContents(), true);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 422) {
                $data = json_decode($e->getResponse()->getBody(), true);
                throw new SpurValidationException($data['message'], $data['errors']);
            }

            throw $e;
        }
    }

    protected function getClient()
    {
        return new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$this->authToken,
            ],
        ]);
    }
}
