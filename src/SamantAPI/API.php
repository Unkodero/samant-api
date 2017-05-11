<?php

namespace SamantAPI;


use SamantAPI\Exception\ApiException;
use SamantAPI\Exception\AuthException;
use SamantAPI\Exception\RequestException;

/**
 * Class API
 * @package SamantAPI
 */
class API
{
    /**
     * API URL
     */
    const API_URL = 'http://samant.deacrm.ru/rest/orders/';

    /**
     * AUTH URL
     */
    const AUTH_URL = 'http://samant.deacrm.ru/login.html';

    /**
     * @var null|string
     */
    private $cookie = null;

    /**
     * API constructor.
     *
     * @param $username
     * @param $password
     * @throws AuthException
     */
    public function __construct($username, $password)
    {
        $this->cookie = dirname(__FILE__) . '/Storage/cookie.txt';

        $response = $this->request(self::AUTH_URL, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'username' => $username,
                'password' => $password,
                'returnUrl' => 'login.html',
                'service' => 'login'
            ])
        ], true);

        if (!preg_match("/Выход/", $response)) {
            throw new AuthException('401 Unauthorized');
        }
    }

    /**
     * Get Order
     * @param $id - Order id
     * @return array
     */
    public function getOrder($id)
    {
        return $this->request(self::API_URL . $id);
    }

    /**
     * Get order model
     * @return Model\OrderModel
     */
    public function makeOrder()
    {
        return new Model\OrderModel($this);
    }

    /**
     * Send order
     *
     * @param Model\OrderModel $order
     * @return mixed
     */
    public function sendOrder(Model\OrderModel $order)
    {
        $order = $this->request(self::API_URL, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'Customer' => get_object_vars($order)
            ]),
            CURLOPT_HTTPHEADER => ["Content-type: multipart/form-data"]
        ]);

        return [
            'order_id' => $order['id'],
            'track_number' => $order['track']
        ];

    }

    /**
     * @param $url
     * @param array $parameters
     * @param $isAuth
     *
     * @return mixed
     *
     * @throws RequestException
     * @throws AuthException
     * @throws ApiException
     */
    private function request($url, $parameters = [], $isAuth = false)
    {
        $curl = curl_init($url);

        curl_setopt_array($curl, $parameters + [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_COOKIEJAR => $this->cookie,
                CURLOPT_COOKIEFILE => $this->cookie
            ]);

        $response = curl_exec($curl);

        if (!$isAuth) {
            $response = json_decode($response, true);
        }

        if ($response === false) {
            throw new RequestException(curl_error($curl));
        } elseif (curl_getinfo($curl, CURLINFO_RESPONSE_CODE) === 401) {
            throw new AuthException('401 Unauthorized');
        } elseif (!$isAuth && !$response['success']) {
            throw new ApiException($response['message']);
        }

        curl_close($curl);

        return ($isAuth ? $response : $response['data']);
    }

}
