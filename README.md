# UpcPaymentPHPSdk

### Підпис даних

Приклад використання 
```php
<?php
require __DIR__ . '/../app/sdk.php';

use UPC\UpcSDK;
use UPC\UpcPaymentData;

$sdk = new UpcSDK(__DIR__ . '/../keys/private.pem');
$payment_data = new UpcPaymentData('77777799004', 'E9977774', 1111, '23', '520', 100);

$signature = $sdk->signature($payment_data);

var_dump($signature);

```
**UpcSDK** клас, в коструктор потрібно передати шлях до приватного ключа
	**UpcSDK->signature** метод для формування підпису, приймає обєкт UpcPaymentData
**UpcPaymentData** клас, для формування об'єкту платежу, в конструктор потрібно передати  наступні параметри:
- string $MerchantID; 
- string $TerminalID;
- int $PurchaseTime;
- string $OrderID;
- string $Currency;
- int $TotalAmount;

Приклад 
```php
$payment_data = new UpcPaymentData('77777799004', 'E9977774', 1111, '23', '520', 100);
```

### Повернення
```php
<?php
require __DIR__ . '/../app/sdk.php';

use UPC\UpcSDK;
$sdk = new UpcSDK(__DIR__ . '/../keys/private.pem');

$reversal = $sdk->reversal(
    [
        'MerchantID' => '77777799004',
        'TerminalID' => `E9977774`,
        "PurchaseTime" => time(),
        "OrderID" => 1,
        "CurrencyID" => "980",
        "TotalAmount" => 100,
        "RRN" => "AX1122121212",
        "ApprovalCode" => 121212,
        "RefundAmount" => 100
    ]
);


```

------------
### Підпис даних

Для підпису використовується клас Sign, кожен метод є статичним, приймає параметри і шлях до ключа

```php
<?php
use UPC\Sign;

Sign::paymentSign($params, $privateKeyPath);
Sign::recurrentPaymentSign($params, $privateKeyPath);
Sign::reversalPaymentSign($params, $privateKeyPath);
Sign::preAuthorizationSign($params, $privateKeyPath);
```

приклад
```php
<?php 
use UPC\Sign;

 $signature = Sign::reversalPaymentSign($params, $private_key);
```

###  Запит стану транзакції
Приклад використання
```php
<?php
require __DIR__ . '/../app/sdk.php';

use UPC\UpcSDK;
use UPC\UpcPaymentData;

$sdk = new UpcSDK(__DIR__ . '/../keys/private.pem');
$payment_data = new UpcPaymentData('77777799004', 'E9977774', 1111, '23', '520', 100);

$trans_state = $sdk->tranState($payment_data, 'ecg.test.upc.ua');

var_dump($trans_state);

```

**UpcSDK** клас, в коструктор потрібно передати шлях до приватного ключа
	**UpcSDK->tranState** метод для формування підпису, приймає обєкт UpcPaymentData, а також як опціональний парамер- урл для тестового середовища це буде хост **ecg.test.upc.ua** 



### Створення форми  
Приклад використання

```php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
</head>

<body>

    <?php
    require __DIR__ . '/../app/sdk.php';

    use UPC\UpcSDK;
    use UPC\UpcPaymentData;

    $sdk = new UpcSDK(__DIR__ . '/../keys/private.pem');
   

    $signature = $sdk->signature($payment_data);
    $trans_state = $sdk->tranState($payment_data, "secure.upc.ua");


        $post_data = [
            'Version' => 1,
            'MerchantID' => '1111111',
            'TerminalID'   => 'E9977774',
            'TotalAmount' => 1111,
            'Currency' => '980',
            'locale' => 'en',
            'PurchaseTime' => 150611110821,
            'OrderID' => '150611110821x',
            'PurchaseDesc' => 'tran test',
        ];
        $payment_data = new UpcPaymentData($post_data['MerchantID'], 
                                        $post_data['TerminalID'],
                                        $post_data['PurchaseTime'], 
                                        $post_data['OrderID'],
                                        $post_data['Currency'],
                                        $post_data['TotalAmount'] );
        $post_data['Signature'] = $sdk->signature($payment_data);
    ?>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <form action="https://secure.upc.ua/go/pay" method="POST">
        <?php 
            foreach ($post_data as $name => $value) {
                echo "<input name=\"$name\" type=\"hidden\" value=\"$value\" />";
            }
        
        ?>
        <input type="submit" />
    </form>

</body>

</html>
```