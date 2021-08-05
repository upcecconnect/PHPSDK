<?php
require __DIR__ . '/../app/sdk.php';

use UPC\UpcSDK;
use UPC\UpcPaymentData;

$sdk = new UpcSDK(__DIR__ . '/../keys/private.pem');
$payment_data = new UpcPaymentData('77777799004', 'E9977774', 1111, '23', '520', 100);

$signature = $sdk->signature($payment_data);
$trans_state = $sdk->tranState($payment_data, "ecg.test.upc.ua");

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

var_dump($reversal);
