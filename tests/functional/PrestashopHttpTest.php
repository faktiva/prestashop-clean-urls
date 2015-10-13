<?php

require_once __DIR__.'/../../vendor/autoload.php';

class PrestashopHttpTest extends Sauce\Sausage\WebDriverTestCase
{
    protected $base_url;

    public static $browsers = array(
        array(
            'browserName' => 'chrome',
            'desiredCapabilities' => array(
                'platform' => 'Linux',
            ),
        ),
        /*
        array(
            'browserName' => 'chrome',
            'desiredCapabilities' => array(
                'platform' => 'VISTA',
            ),
        ),
        */
    );

    public function __construct()
    {
        parent::__construct();
        $this->base_url = sprintf('%s://%s%s', getenv('TEST_PROTO'), getenv('TEST_HOST'), getenv('TEST_BASE_DIR'));
    }

    public function testBackOfficeTitle()
    {
        $this->url($this->base_url.'_admin/');
        $this->assertContains('Test Shop', $this->title());
    }
}
