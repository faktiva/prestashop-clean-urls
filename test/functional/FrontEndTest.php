<?php

require_once __DIR__.'/../../vendor/autoload.php';

class FrontEndTest extends Sauce\Sausage\WebDriverTestCase
{
    protected $base_url;

    public static $browsers = array(
        array(
            'browserName' => 'firefox',
            'seleniumServerRequestsTimeout' => 120,
            'desiredCapabilities' => array(
                'platform' => 'Linux',
                'tags' => array('zzCleanURLs', 'frontend'),
                'recordVideo' => false,
                'captureHtml' => true,
                'idleTimeout' => 90,
                'commandTimeout' => 300,
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
        $this->assertTrue((bool)$this->byCss('body#index'));
    }

    public function testProductPage()
    {
        $this->url('/evening-dresses/printed-dress');
        $this->assertTrue((bool)$this->byCss('body#product'));
    }

    public function testCategoryPage()
    {
        $this->url('/women');
        $this->assertTrue((bool)$this->byCss('body#category'));
    }

    public function testCmsPage()
    {
        $this->url('/content/about-us');
        $this->assertTrue((bool)$this->byCss('body#cms'));
    }

    public function testManufacturerPage()
    {
        $this->url('/manifacturers');
        $this->assertTrue((bool)$this->byCss('body#manufacturer'));

        $this->url('/fashion-manufacturer');
        $this->assertTrue((bool)$this->byCss('body#manufacturer'));
    }

    public function testSuppliersPage()
    {
        $this->url('/supplier');
        $this->assertTrue((bool)$this->byCss('body#supplier'));

        $this->url('/fashion-supplier');
        $this->assertTrue((bool)$this->byCss('body#supplier'));
    }
}
