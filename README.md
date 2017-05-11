# Samant API Wrapper
## Usage

```php
<?php

require_once 'vendor/autoload.php';

use SamantAPI\API;

try {
    $api = new API('login', 'password');
} catch (\SamantAPI\Exception\AuthException $e) {
    throw $e;
}

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
//See Model\OrderModel

try {
    var_dump($api->sendOrder($order));
} catch (\SamantAPI\Exception\ApiException $e) {
    throw $e;
} catch (\SamantAPI\Exception\RequestException $e) {
    throw $e;
}
```

## Responses

```php
//var_dump($api->sendOrder($order));

array(2) {
  ["order_id"]=>
  int(85)
  ["track_number"]=>
  string(11) "RU051700025"
}


//var_dump($api->getOrder(79));

array(30) {
  ["id"]=>
  int(79)
  ["client_id"]=>
  int(0)
  ["country_id"]=>
  int(1)
  ["name"]=>
  string(0) ""
  ["description"]=>
  string(0) ""
  ["createdby"]=>
  int(34)
  ["createdon"]=>
  string(10) "11.05.2017"
  ["editedby"]=>
  int(0)
  ["editedon"]=>
  int(0)
  ["deleted"]=>
  bool(false)
  ["deletedon"]=>
  int(0)
  ["deletedby"]=>
  int(0)
  ["stage_id"]=>
  int(1)
  ["documentno"]=>
  string(0) ""
  ["dateordered"]=>
  int(0)
  ["customer_id"]=>
  int(91)
  ["courier_id"]=>
  int(0)
  ["waybill_id"]=>
  int(0)
  ["shipment_id"]=>
  int(0)
  ["date"]=>
  int(0)
  ["track"]=>
  string(11) "RU051700019"
  ["totallines"]=>
  int(0)
  ["trynum"]=>
  int(0)
  ["grandtotal"]=>
  int(0)
  ["assign"]=>
  bool(false)
  ["processing"]=>
  bool(false)
  ["OrderStage"]=>
  array(15) {
    ["id"]=>
    int(1)
    ["name"]=>
    string(10) "Новые"
    ["description"]=>
    string(12) "Старый"
    ["createdby"]=>
    int(0)
    ["createdon"]=>
    int(0)
    ["editedby"]=>
    int(1)
    ["editedon"]=>
    string(19) "2017-04-25 19:33:20"
    ["deleted"]=>
    bool(false)
    ["deletedon"]=>
    int(0)
    ["deletedby"]=>
    int(0)
    ["color"]=>
    string(5) "slate"
    ["active"]=>
    int(0)
    ["final"]=>
    int(0)
    ["sort"]=>
    int(1)
    ["dashboard"]=>
    bool(true)
  }
  ["Customer"]=>
  array(29) {
    ["id"]=>
    int(91)
    ["createdby"]=>
    int(0)
    ["createdon"]=>
    int(0)
    ["editedby"]=>
    int(0)
    ["editedon"]=>
    int(0)
    ["fullname"]=>
    string(38) "Иванов Иван Иванович"
    ["email"]=>
    string(16) "test@example.com"
    ["phone"]=>
    string(11) "11111100000"
    ["mobilephone"]=>
    string(5) "37449"
    ["blocked"]=>
    bool(false)
    ["blockeduntil"]=>
    int(0)
    ["blockedafter"]=>
    int(0)
    ["gender"]=>
    int(0)
    ["address"]=>
    string(0) ""
    ["country"]=>
    string(0) ""
    ["city"]=>
    string(4) "test"
    ["city_id"]=>
    int(1)
    ["metro"]=>
    string(41) "Петровско-разумовская"
    ["state"]=>
    string(8) "Край"
    ["zip"]=>
    string(6) "355023"
    ["fax"]=>
    string(6) "123123"
    ["photo"]=>
    string(0) ""
    ["comment"]=>
    string(12) "test comment"
    ["website"]=>
    string(0) ""
    ["extended"]=>
    NULL
    ["lat"]=>
    float(59.939095)
    ["long"]=>
    float(30.315868)
    ["fence_id"]=>
    int(0)
    ["City"]=>
    array(15) {
      ["id"]=>
      int(1)
      ["name"]=>
      string(29) "Санкт-Петербург"
      ["value"]=>
      string(0) ""
      ["description"]=>
      string(0) ""
      ["comment"]=>
      string(0) ""
      ["timezone"]=>
      int(0)
      ["rate"]=>
      int(0)
      ["image_url"]=>
      string(0) ""
      ["lat"]=>
      float(59.9)
      ["long"]=>
      float(30.33)
      ["country_id"]=>
      int(1)
      ["createdon"]=>
      NULL
      ["createdby"]=>
      int(0)
      ["editedon"]=>
      NULL
      ["editedby"]=>
      int(0)
    }
  }
  ["Timeline"]=>
  array(0) {
  }
  ["customer_name"]=>
  string(38) "Иванов Иван Иванович"
}

```

