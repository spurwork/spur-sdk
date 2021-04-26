<?php

namespace Spur;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

abstract class SpurClientBase
{
    protected $baseUrl;
    protected $optional = "";
    protected $authToken;
    protected $timeOffset;

    public function __construct($baseUrl, $authToken, $timeOffset = null)
    {
        $this->baseUrl = $baseUrl;
        $optional_string = str_replace("http://", "", $baseUrl);
        $optional_string = str_replace("https://", "", $optional_string);
        $this->optional = strpos($optional_string, '/') === false
            ? ""
            : substr($optional_string, strpos($optional_string, '/'))."/";
        $this->authToken = $authToken;
        $this->timeOffset = $timeOffset;
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
            return json_decode($this->getClient()->request($method, $this->optional.$url, $options)->getBody()->getContents(), true);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 422) {
                $data = json_decode($e->getResponse()->getBody(), true);
                throw new SpurValidationException($data['message'], array_key_exists('errors', $data) ? $data['errors'] : []);
            }

            if ($e->getResponse()->getStatusCode() >= 400 && $e->getResponse()->getStatusCode() <= 599) {
                $data = json_decode($e->getResponse()->getBody(), true);
                throw new SpurApiException($data['message'], $e->getCode());
            }

            throw $e;
        }
    }

    protected function getClient()
    {
        return new Client([
            'base_uri' => $this->baseUrl,
            'headers' => $this->getHeaders(),
        ]);
    }

    protected function getHeaders()
    {
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->authToken,
        ];

        if ($this->timeOffset) {
            $headers['X-Flux-Capacitor'] = $this->timeOffset;
        }

        return $headers;
    }
}
