<?php
namespace Am0nshi\Nextel;

use Am0nshi\Nextel\Exceptions\NextelException;

class Network
{
    protected $options = [
        'headers' => [
            'Authorization' => ''
        ]
    ];

    protected $uri = 'https://cstat.nextel.com.ua:8443/tracking/api';

    protected $client;

    public function __construct($apiKey)
    {
        $this->options['headers']['Authorization'] = $apiKey;

        $this->client = new \GuzzleHttp\Client();
    }

    public function json($uri, $data)
    {
        $json = $this->doRequest($uri, array_merge_recursive(['json' => $data], $this->options));

        if ($json->status == "Error") {
            NextelException::getException($json->message);
        }

        return $json;

        return $this->post($uri, $data);
    }

    public function post($uri, $data)
    {
        $json = $this->doRequest($uri, array_merge_recursive(['multipart' => $data], $this->options));

        if ($json->status == "Error") {
            NextelException::getException($json->message);
        }

        return $json;
    }

    public function doRequest($uri, $body, $method = 'POST')
    {
        $response = $this->client->request($method, $this->normalizeUri($uri), array_merge_recursive($body, $this->options));

        return \json_decode($response->getBody());
    }

    /**
     * @param $uri
     *
     * @return string
     */
    protected function normalizeUri($uri)
    {
        return $this->uri . $uri;
    }
}