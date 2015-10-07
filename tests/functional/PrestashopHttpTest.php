<?php

require_once __DIR__.'/vendor/autoload.php';

define('SAUCE_HOST', 'ZiZuu:09b878d4-6b56-47dd-b4b8-c018b19b4f61@ondemand.saucelabs.com');

class WebTest extends PHPUnit_Extensions_Selenium2TestCase
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
