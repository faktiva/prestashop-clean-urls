<?php

require_once __DIR__.'/../../vendor/autoload.php';

class PrestashopHttpTest extends Sauce\Sausage\WebDriverTestCase
{
    protected $base_url;
    protected $job_id;

    public function __construct()
    {
        parent::__construct();
        $this->base_url = sprintf('%s://%s%s', getenv('TEST_PROTO'), getenv('TEST_HOST'), getenv('TEST_BASE_DIR'));
        $this->job_id = getenv('TRAVIS_JOB_NUMBER');
    }

    public static $browsers = array(
        array(
            'browserName' => 'chrome',
            'desiredCapabilities' => array(
                'tunnel-identifier' => $this->job_id,
                'platform' => 'VISTA',
            ),
        ),
        array(
            'browserName' => 'chrome',
            'desiredCapabilities' => array(
                'tunnel-identifier' => $this->job_id,
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
