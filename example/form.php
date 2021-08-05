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
    $payment_data = new UpcPaymentData(
        $post_data['MerchantID'],
        $post_data['TerminalID'],
        $post_data['PurchaseTime'],
        $post_data['OrderID'],
        $post_data['Currency'],
        $post_data['TotalAmount']
    );
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