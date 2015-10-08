<?php

require_once __DIR__.'/../../vendor/autoload.php';

class PrestashopHttpTest extends Sauce\Sausage\WebDriverTestCase
{
    protected $base_url;

    public function __construct()
    {
        parent::__construct();
        $this->base_url = sprintf('%s://%s%s', getenv('TEST_PROTO'), getenv('TEST_HOST'), getenv('TEST_BASE_DIR'));
    }

    public static $browsers = array(
        array(
            'browserName' => 'firefox',
            'desiredCapabilities' => array(
                'version' => '15',
                'platform' => 'VISTA',
            ),
        ),
        // run Chrome on Linux on Sauce
        array(
            'browserName' => 'chrome',
            'desiredCapabilities' => array(
                'platform' => 'Linux',
            ),
        ),
    );

    public function setUpPage()
    {
        $this->url($this->base_url);
    }

    public function testTitle()
    {
        $this->assertContains('Test Shop', $this->title());
    }
}
