<?php

namespace TotalCoin;

class Client {

    const API_BASE_URL = "https://api.totalcoin.com/ar/";

    private static function get_connect($uri = '', $method = 'GET', $content_type = 'application/json') {
        $connect = curl_init(self::API_BASE_URL . $uri);

        curl_setopt($connect, CURLOPT_USERAGENT, "TotalCoin PHP v" . Api::version);
        curl_setopt($connect, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($connect, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($connect, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($connect, CURLOPT_HTTPHEADER, array("Accept: application/json", "Content-Type: " . $content_type));

        return $connect;
    }

    private static function set_data(&$connect, $data, $content_type) {
        if ($content_type == "application/json") {
          if (gettype($data) == "string") {
            json_decode($data, true);
          } else {
            $data = json_encode($data);
          }

          if(function_exists('json_last_error')) {
            $json_error = json_last_error();
            if ($json_error != JSON_ERROR_NONE) {
              throw new \Exception("JSON Error [{$json_error}] - Data: {$data}");
            }
          }
        }

        curl_setopt($connect, CURLOPT_POSTFIELDS, $data);
    }

    private static function exec($method, $uri, $data, $content_type) {
        $connect = self::get_connect($uri, $method, $content_type);

        if ($data) {
          self::set_data($connect, $data, $content_type);
        }

        $api_result = curl_exec($connect);
        $api_http_code = curl_getinfo($connect, CURLINFO_HTTP_CODE);

        $response = array(
        "status" => $api_http_code,
        "response" => json_decode($api_result, true)
        );

        if ($response['status'] >= 400) {
          throw new \Exception ('Error Interno', $response['status']);
        }

        curl_close($connect);

        return $response['response'];
    }

    public static function get($uri, $content_type = "application/json") {
        return self::exec("GET", $uri, null, $content_type);
    }

    public static function post($uri, $data, $content_type = "application/json") {
        return self::exec("POST", $uri, $data, $content_type);
    }

    public static function put($uri, $data, $content_type = "application/json") {
        return self::exec("PUT", $uri, $data, $content_type);
    }

}

?>
