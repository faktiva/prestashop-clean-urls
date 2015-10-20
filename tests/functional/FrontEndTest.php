<?php

require_once __DIR__.'/../../vendor/autoload.php';

class FrontEndTest extends Sauce\Sausage\WebDriverTestCase
{
    protected $base_url;

    public static $browsers = array(
        array(
            'browserName' => 'firefox',
            'desiredCapabilities' => array(
                'platform' => 'Linux',
                'tags' => array('zzCleanURLs', 'frontend'),
                'recordVideo' => false,
                'captureHtml' => true,
                'idleTimeout' => 90,
            ),
        ),
    );

    public function __construct()
    {
        parent::__construct();

        $this->base_url = sprintf('%s://%s%s',
            getenv('TEST_PROTO'),
            getenv('TEST_HOST'),
            rtrim(getenv('TEST_BASE_DIR'), '/')
        );
    }

    public function testHomePage()
    {
        $this->url('/');
        $this->assertTrue($this->byCss('body#index'));
    }

    public function testProductPage()
    {
    }
    
    public function testCategoryPage()
    {
    }
    
    public function testCmsPage()
    {
    }
    
    public function testCmsCategoryPage()
    {
    }
}
