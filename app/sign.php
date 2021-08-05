<?php

namespace UPC;

class Sign
{

    public static function paymentSign($params, $privateKeyPath = "")
    {
        $MerchantID = $params['MerchantID'];
        $TerminalID = $params['TerminalID'];
        $PurchaseTime = $params['PurchaseTime'];
        $OrderID = $params['OrderID'];
        $CurrencyID = $params['CurrencyID'];
        $TotalAmount = $params['TotalAmount'];

        $str = "$MerchantID;$TerminalID;$PurchaseTime;$OrderID;$CurrencyID;$TotalAmount;;";
        return self::makeSign($str, $privateKeyPath);
    }


    public static function recurrentPaymentSign($params, $privateKeyPath = "")
    {
        $MerchantID = $params['MerchantID'];
        $TerminalID = $params['TerminalID'];
        $PurchaseTime = $params['PurchaseTime'];
        $OrderID = $params['OrderID'];
        $CurrencyID = $params['CurrencyID'];
        $TotalAmount = $params['TotalAmount'];
        $SessionData = $params['SessionData'];


        $str = "$MerchantID;$TerminalID;$PurchaseTime;$OrderID;$CurrencyID;$TotalAmount;$SessionData;true;";
        return self::makeSign($str, $privateKeyPath);
    }


    public static function reversalPaymentSign($params, $privateKeyPath = "")
    {
        $MerchantID = $params['MerchantID'];
        $TerminalID = $params['TerminalID'];
        $PurchaseTime = $params['PurchaseTime'];
        $OrderID = $params['OrderID'];
        $CurrencyID = $params['CurrencyID'];
        $TotalAmount = $params['TotalAmount'];
        $SessionData = $params['SessionData'] ?? '';
        $ApprovalCode = $params['ApprovalCode'];
        $Ref3 = $params['Ref3'] ?? '';
        $RefundAmount = $params['RefundAmount'] ?? '';
        $RRN = $params['RRN'];

        $str = '';

        if ($Ref3) {
            $str = "$MerchantID;$TerminalID;$PurchaseTime;$OrderID;$CurrencyID;$TotalAmount;$SessionData;$ApprovalCode;$RRN;$Ref3;";
        } else if ($RefundAmount) {
            $str = "$MerchantID;$TerminalID;$PurchaseTime;$OrderID;$CurrencyID;$TotalAmount;$SessionData;$ApprovalCode;$RRN;$RefundAmount;";
        } else {
            $str = "$MerchantID;$TerminalID;$PurchaseTime;$OrderID;$CurrencyID;$TotalAmount;$SessionData;$ApprovalCode;$RRN;";
        }
        return self::makeSign($str, $privateKeyPath);
    }


    public static function preAuthorizationSign($params, $privateKeyPath = "")
    {
        $MerchantID = $params['MerchantID'];
        $TerminalID = $params['TerminalID'];
        $PurchaseTime = $params['PurchaseTime'];
        $OrderID = $params['OrderID'];
        $CurrencyID = $params['CurrencyID'];
        $TotalAmount = $params['TotalAmount'];
        $SessionData = $params['SessionData'];

        $str = "$MerchantID;$TerminalID;$PurchaseTime;$OrderID;$CurrencyID;$TotalAmount;$SessionData;";
        return self::makeSign($str, $privateKeyPath);
    }


    public static function makeSign($formated_string, $privateKeyPath)
    {
        openssl_sign($formated_string, $signature, file_get_contents($privateKeyPath));

        return base64_encode($signature);
    }
}
