<?php

namespace TotalCoin;

class Api {

    const version = "0.1";

    private $api_key;
    private $client_email;

    function __construct($client_email, $api_key) {
        $this->client_email = $client_email;
        $this->api_key = $api_key;
    }

    public function perform_checkout($params) {
        $access_token = $this->get_access_token();

        $result = Client::post("Checkout/" . $access_token, $params);

        return $result;
    }

    public function get_access_token() {
        $app_client_values = Array(
          'Email' => $this->client_email,
          'ApiKey' => $this->api_key,
        );

        $access_data = Client::post("Security", $app_client_values);

        return $access_data['Response']['TokenId'];
    }

    public function get_merchants() {
        $access_token = $this->get_access_token();

        $result = Client::get("Merchant/" . $access_token);

        return $result;
    }

    public function get_ipn_info($reference_id) {
        $data = Client::get("Ipn/" . $this->api_key . "/" . $reference_id);

        return $data;
    }
}


?>
