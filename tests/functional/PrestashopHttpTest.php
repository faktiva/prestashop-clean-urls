<?php

require_once __DIR__.'/../vendor/autoload.php';

define('SAUCE_HOST', $_ENV['SAUCE_USERNAME'].':'.$_ENV['SAUCE_ACCESS_KEY'].'@ondemand.saucelabs.com');

class PrestashopHttpTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected $start_url = 'http://localhost/prestashop.test/';

    public static $browsers = array(
        array(
            'browserName' => 'firefox',
            'host' => SAUCE_HOST,
            'port' => 80,
            'desiredCapabilities' => array(
                'version' => '15',
                'platform' => 'Windows 2012',
            ),
        ),
    );

    protected function setUp()
    {
        $this->setBrowserUrl('');
    }

    public function testTitle()
    {
        $this->url($this->start_url);
        $this->assertContains('Prestashop Shop', $this->title());
    }
}
