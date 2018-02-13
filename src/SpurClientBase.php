<?php

namespace Spur;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

abstract class SpurClientBase
{
    public static $BASE_URL = "https://api.spurjobs.com";
    public static $VERIFY_SSL = true;

    protected $authorization_token = null;
    protected $authorization_header = null;
    protected $version = null;
    protected $os = null;
    protected $timeout = 30;
    protected $client;

    protected function __construct($token, $header, $timeout = 30)
    {
        $this->authorization_token = $token;
        $this->authorization_header = $header;
        $this->version = phpversion();
        $this->os = PHP_OS;
        $this->timeout = $timeout;
    }

    protected function getClient(): Client
    {
        if (!$this->client) {
            $this->client = new Client([
                'base_uri' => self::$BASE_URL,
                RequestOptions::VERIFY => self::$VERIFY_SSL,
                RequestOptions::TIMEOUT => $this->timeout,
            ]);
        }

        return $this->client;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    protected function processRestRequest($method = null, $path = null, array $body = [])
    {
        $client = $this->getClient();

        $options = [
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::HEADERS => [
                'User-Agent' => "Spur-PHP (PHP Version:{$this->version}, OS:{$this->os})",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                $this->authorization_header => $this->authorization_token
            ],
        ];

        if (!empty($body)) {
            $cleanParams = array_filter($body, function ($value) {
                return $value !== null;
            });

            switch ($method) {
                case 'GET':
                case 'HEAD':
                case 'DELETE':
                case 'OPTIONS':
                    $options[RequestOptions::QUERY] = $cleanParams;
                    break;
                case 'PUT':
                case 'POST':
                case 'PATCH':
                    $options[RequestOptions::JSON] = $cleanParams;
                    break;
            }
        }

        $response = $client->request($method, $path, $options);

        switch ($response->getStatusCode()) {
            case 200:
                return json_decode($response->getBody(), true);
            case 401:
                $ex = new SpurException();
                $ex->message = 'Unauthorized: Missing or incorrect API token in header. '.
                    'Please verify that you used the correct token when you constructed your client.';
                $ex->http_status_code = 401;
                throw $ex;
            case 500:
                $ex = new SpurException();
                $ex->http_status_code = 500;
                $ex->message = 'Internal Server Error: This is an issue with Spur’s servers processing your request. '.
                    'In most cases the message is lost during the process, '.
                    'and Spur is notified so that we can investigate the issue.';
                throw $ex;
            case 503:
                $ex = new SpurException();
                $ex->http_status_code = 503;
                $ex->message = 'The Spur API is currently unavailable, please try your request later.';
                throw $ex;
            // This should cover case 422, and any others that are possible:
            default:
                $ex = new SpurException();
                $body = json_decode($response->getBody(), true);
                $ex->http_status_code = $response->getStatusCode();
                $ex->spur_api_error_code = $body['ErrorCode'];
                $ex->message = $body['Message'];
                throw $ex;
        }
    }
}
