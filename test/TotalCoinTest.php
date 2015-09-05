<?php

require_once __DIR__ . '/../vendor/autoload.php';

use TotalCoin\Api;
use TotalCoin\Client;

class TotalCoinTest extends PHPUnit_Framework_TestCase {

    protected function setUp() {
        $this->api = new Api(PHPUNIT_TESTSUITE_EMAIL_LOGIN, PHPUNIT_TESTSUITE_APIKEY);
    }

    public function test_get_access_token() {
        $token = $this->api->get_access_token();

        $this->assertTrue(strlen($token) > 0);
    }

    public function test_perform_checkout() {
        $data = Array();
        $data['Amount'] = 600;
        $data['Quantity'] = 1;
        $data['Country'] = "ARG";
        $data['Currency'] = "ARS";
        $data['Description'] = "Zapatillas";
        $data['PaymentMethods'] = "CREDITCARD|CASH|TOTALCOIN";
        $data['Reference'] = "12123322";
        $data['Site'] = "PHP SDK";
        $data['MerchantId'] = "AAAAAA-BBBB-CCCC-DDDD-EEEEEEEE";

        $results = $this->api->perform_checkout($data);
        $checkout_url = $results['Response']['URL'];

        $this->assertTrue(is_array($results));
        $this->assertTrue($results['IsOk']);
        $this->assertTrue(strlen($checkout_url) > 0);
        $this->assertTrue((bool)preg_match("#^https?://.+#", $checkout_url));
    }

    public function test_get_merchants() {
        $results = $this->api->get_merchants();
        $merchants = $results['Response'];

        $this->assertTrue((bool)$results['IsOk']);
        $this->assertTrue(is_array($merchants));
    }

    public function test_get_ipn_info() {
        $results = $this->api->get_ipn_info("000000000");
        $data = $results['Response'];

        $this->assertTrue((bool)$results['IsOk']);
        $this->assertTrue(is_array($data));
    }
}

?>
