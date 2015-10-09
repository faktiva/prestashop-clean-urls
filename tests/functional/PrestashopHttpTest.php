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

    public function setUpPage()
    {
        $this->setUpSpecificBrowser(array(
            array(
                'browserName' => 'chrome',
                'desiredCapabilities' => array(
                    'tunnel-identifier' => getenv('TRAVIS_JOB_NUMBER'),
                    'platform' => 'VISTA',
                ),
            ),
            array(
                'browserName' => 'chrome',
                'desiredCapabilities' => array(
                    'tunnel-identifier' => getenv('TRAVIS_JOB_NUMBER'),
                    'platform' => 'Linux',
                ),
            ),
        ));

        $this->url($this->base_url);
    }

    public function testTitle()
    {
        $this->assertContains('Test Shop', $this->title());
    }
}
