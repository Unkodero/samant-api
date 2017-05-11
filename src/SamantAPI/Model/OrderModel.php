<?php

namespace SamantAPI\Model;


class OrderModel
{
    private $api;

    public $fullname;
    public $email;
    public $phone;
    public $mobilephone;
    public $city;
    public $city_id;
    public $country;
    public $gender;
    public $address;
    public $metro;
    public $state;
    public $zip;
    public $fax;
    public $comment;

    public function __construct(\SamantAPI\API $api) {
        $this->api = $api;
    }

    public function send()
    {
        return $this->api->sendOrder($this);
    }

}