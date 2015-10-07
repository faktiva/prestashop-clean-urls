<?php

require_once '../vendor/autoload.php';
define('__TEST_BASE_URL__', 'http://localhost/prestashop.test/');

class PrestashopHttpTest extends Sauce\Sausage\SeleniumRCTestCase
{
    public static $browsers = array(
        // FF 11 on Sauce
        /*array(
            'browser' => 'firefox',
            'browserVersion' => '11',
            'os' => 'Windows 2003'
        ),*/
        //Chrome on Linux on Sauce
        array(
            'browser' => 'googlechrome',
            'browserVersion' => '',
            'os' => 'Linux'
        ),
        //Chrome on local machine
        /*array(
            'browser' => 'googlechrome',
            'local' => true
        ),*/
    );

    public function setUp()
    {
        $this->setBrowserUrl(__TEST_BASE_URL__);
    }

    public function postSessionSetUp()
    {
        $this->open(__TEST_BASE_URL__);
    }

    public function testTitle()
    {
        $this->assertTitle("Prestashop Shop");
    }

}
