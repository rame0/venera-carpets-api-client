<?php

namespace rame0\Venera\API;

use PHPUnit\Util\Exception;

class Client
{
    private string $_token = "";
    private string $_api_url = "";
    private ?string $_cache_storage_path = null;

    public function __construct(
        string  $token,
        ?string $cache_storage_path = null,
        string  $api_url = "https://api.venera-carpet.ru/api/"
    )
    {
        $this->_token = $token;
        $this->_api_url = $api_url;
        $this->_cache_storage_path = $cache_storage_path;
    }

    /**
     * @param string $method
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function request(string $method, array $params)
    {
        $params['token'] = $this->_token;

        $query_string = http_build_query($params);

        $url = $this->_api_url . $method . '?' . $query_string;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $head = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if (empty($head)) {
            throw new \Exception("Curl request returned empty head!");
        }

        $response = json_decode($head);


        if ($httpCode != 200) {
            throw new Exception("$response->title $response->message");
        }

        return $response;
    }
}