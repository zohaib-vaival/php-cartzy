<?php
/**
 * Created by PhpStorm.
 * @author Muhammad Zohaib <muhammad.zohaib@vaivaltech.com>
 * Created at: 12/11/2020 11:32 AM UTC+05:00
 */

namespace PHPShopify;


use PHPShopify\Exception\SdkException;

class HttpRequestGraphQL extends HttpRequestJson
{
    /**
     * Prepared GraphQL string to be posted with request
     *
     * @var string
     */
    private static $postDataGraphQL;

    /**
     * Prepare the data and request headers before making the call
     *
     * @param array $httpHeaders
     * @param mixed $data
     * @param array|null $variables
     *
     * @return void
     *
     * @throws SdkException if $data is not a string
     */
    protected static function prepareRequest($httpHeaders = array(), $data = array(), $variables = null)
    {

        if (is_string($data)) {
            self::$postDataGraphQL = $data;
        } else {
            throw new SdkException("Only GraphQL string is allowed!");
        }

        if (!isset($httpHeaders['X-Shopify-Access-Token'])) {
            throw new SdkException("The GraphQL Admin API requires an access token for making authenticated requests!");
        }

        self::$httpHeaders = $httpHeaders;

        if (is_array($variables)) {
            self::$postDataGraphQL = json_encode(['query' => $data, 'variables' => $variables]);
            self::$httpHeaders['Content-type'] = 'application/json';
        } else {
            self::$httpHeaders['Content-type'] = 'application/graphql';
        }
    }

    /**
     * Implement a POST request and return json decoded output
     *
     * @param string $url
     * @param mixed $data
     * @param array $httpHeaders
     * @param array|null $variables
     *
     * @return string
     */
    public static function post($url, $data, $httpHeaders = array(), $variables = null)
    {
        self::prepareRequest($httpHeaders, $data, $variables);

        $response = CurlRequest::post($url, self::$postDataGraphQL, self::$httpHeaders);

        return self::processResponse($response);
    }
}