<?php

require_once __DIR__.'/../../vendor/autoload.php';

class PrestashopBackOfficeTest extends Sauce\Sausage\WebDriverTestCase
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
        
        $_base_url = sprintf('%s://%s%s', getenv('TEST_PROTO'), getenv('TEST_HOST'), getenv('TEST_BASE_DIR'));
        $this->base_url = rtrim($base_url), '/');
    }
    
    public function testBackOfficeTitle()
    {
        $this->timeouts()->implicitWait(10000);
        $this->timeouts()->pageLoad(10000);
        $this->timeouts()->asyncScript(10000);

        $url = $this->base_url.'/_admin/';
        
        $this->url($url);
        $this->assertContains('Test Shop', $this->title());
    }
}
