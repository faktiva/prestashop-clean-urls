<?php

require_once __DIR__.'/../vendor/autoload.php';

class PrestashopHttpTest extends Sauce\Sausage\WebDriverTestCase
{
    protected static $sauce_host;
    protected static $base_url;

    public function __construct()
    {
        parent::__construct();

        self::$sauce_host = sprintf('%s:%s@ondemand.saucelabs.com', getenv('SAUCE_USERNAME'), getenv('SAUCE_ACCESS_KEY'));
        self::$base_url = sprintf('%s://%s%s', getenv('TEST_PROTO'), getenv('TEST_HOST'), getenv('TEST_BASE_DIR'));
    }

    public static $browsers = array(
        array(
            'browserName' => 'firefox',
            'host' => self:$sauce_host,
            'port' => 80,
            'desiredCapabilities' => array(
                'version' => '15',
                'platform' => 'Windows 2012',
            ),
        ),
    );

    public function setUpPage()
    {
        $this->url(self::$base_url);
    }

    public function testTitle()
    {
        $this->assertContains('PrestaShop', $this->title());
    }
}
