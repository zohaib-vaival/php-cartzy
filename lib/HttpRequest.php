<?php
namespace PHPCartzy;

use PHPCartzy\Exception\SdkException;

class HttpRequest
{
    private $headers = [];
    private $apiEndpoint;

    /**
     * HttpRequest constructor.
     */
    public function __construct() {
        $config = CartzySDK::$config;
        $clientID = $config['ClientID'];
        $accessToken = $config['AccessToken'];

        $this->headers = array(
            'access-token' => $accessToken,
            'client-id' => $clientID
        );

        $this->apiEndpoint = $config['ApiUrl'];
    }

    /**
     * @param $uri
     * @return mixed
     * @throws SdkException
     */
    public function get($uri) {
        try {
            $response = HttpRequestJson::get( $this->apiEndpoint. $uri, $this->headers);
            return $this->_handleResponse($response);
        } catch (SdkException $ex) {
            throw $ex;
        }
    }

    /**
     * @param $uri
     * @param array $data
     * @return mixed
     * @throws SdkException
     */
    public function post($uri, $data = []) {
        try {
            $response = HttpRequestJson::post( $this->apiEndpoint. $uri, $data, $this->headers);
            return $this->_handleResponse($response);
        } catch (SdkException $ex) {
            throw $ex;
        }
    }

    /**
     * @param $response
     * @return mixed
     * @throws SdkException
     */
    private function _handleResponse($response) {
        if(empty($response)) {
            throw new SdkException("Could not get api response");
        }

        return $response;
    }

}