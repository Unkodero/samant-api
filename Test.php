<?php

require_once 'vendor/autoload.php';

use SamantAPI\API;

$api = new API('admin', 'zxcasd123');

var_dump($api->getOrder(79));

$order = $api->makeOrder();
//$order = new SamantAPI\Model\OrderModel($api);

$order->zip = 355023;
$order->city_id = 1;
$order->city = 'test';
$order->email = 'test@example.com';
$order->comment = 'test comment';
$order->fax = 123123;
$order->metro = 'Петровско-разумовская';
$order->fullname = 'Иванов Иван Иванович';
$order->mobilephone = 0000111111;
$order->phone = 11111100000;
$order->state = 'Край';

var_dump($api->sendOrder($order));