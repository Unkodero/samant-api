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
    const API_URL = 'http://samant.deacrm.ru/rest/';

    /**
     * @var
     */
    private $username;
    /**
     * @var
     */
    private $token;

    /**
     * API constructor.
     *
     * @param $username
     * @param $token
     * @throws AuthException
     */
    public function __construct($username, $token)
    {
        $this->username = $username;
        $this->token = $token;
    }

    /**
     * Get Order
     * @param $id - Order id
     * @return array
     */
    public function getOrder($id = null)
    {
        return $this->request("Orders/{$id}");
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
        $order = $this->request('Orders', [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'Customer' => get_object_vars($order),
                'username' => $this->username,
                'token' => $this->token
            ]),
            CURLOPT_HTTPHEADER => ["Content-type: multipart/form-data"]
        ]);

        return [
            'order_id' => $order['id'],
            'track_number' => $order['track']
        ];

    }

    /**
     * @param $method
     * @param array $parameters
     * @return mixed
     * @throws ApiException
     * @throws RequestException
     */
    private function request($method, $parameters = [])
    {
        $url = self::API_URL . "{$method}/?username={$this->username}&token={$this->token}";

        $curl = curl_init($url);

        curl_setopt_array($curl, $parameters + [
                CURLOPT_RETURNTRANSFER => true,
                ]);

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response === false) {
            throw new RequestException(curl_error($curl));
        } else {
            $response = json_decode($response, true);
        }

        if (!$response['success']) {
            throw new ApiException($response['message']);
        }

        return $response['data'];
    }

}
