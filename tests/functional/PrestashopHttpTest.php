<?php

require_once __DIR__.'/../vendor/autoload.php';

define('SAUCE_HOST', sprintf('%s:%s@ondemand.saucelabs.com', getenv('SAUCE_USERNAME'), getenv('SAUCE_ACCESS_KEY')));
define('BASE_URL', getenv('TEST_PROTO').'://'.getenv('TEST_HOST').getenv('TEST_BASE_URI'));

class PrestashopHttpTest extends Sauce\Sausage\WebDriverTestCase
{
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

    public function setUpPage()
    {
        $this->url(BASE_URL);
    }

    public function testTitle()
    {
        $this->assertContains('Prestashop Shop', $this->title());
    }
}
