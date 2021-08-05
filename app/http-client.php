<?php

namespace UPC;

use Error;

class HttpClient
{

    public static function postJSON($url, $payload)
    {
        $ch = curl_init($url);

        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            $payload
        );
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array('Content-Type:application/json')
        );
        curl_setopt(
            $ch,
            CURLOPT_RETURNTRANSFER,
            true
        );
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public static function post($url, $payload){
        $ch = curl_init($url);

        $defaults = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($payload),
            );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $defaults);


        $response = curl_exec($ch);
        return $response;
    }
}
