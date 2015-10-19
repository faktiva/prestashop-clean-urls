<?php

require_once __DIR__.'/../../vendor/autoload.php';

class PrestashopBackOfficeTest extends Sauce\Sausage\WebDriverTestCase
{
    protected $base_url;

    public static $browsers = array(
        array(
            'browserName' => 'firefox',
            'desiredCapabilities' => array(
                'platform' => 'Linux',
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
    
    protected function tokenUrl($url)
    {
        $qs = parse_str(parse_url($this->url(), PHP_URL_QUERY));
        $delim = (false !== strpos($url, '?')) ? '?' : '&';

        return $this->url($url.$delim.'token='.$qs['token']);
    }

    protected function doAdminLogin($user, $passwd)
    {
        $this->url('/_admin/');

        $this->byName('email')->value('test@example.com');
        $this->byName('passwd')->value('0123456789');
        $this->byName('submitLogin')->click();

        $this->assertTextPresent('Dashboard');
    }

    protected function doLogout()
    {
        $this->url('/_admin/index.php?controller=AdminLogin&logout');

        $this->byId('login_form');
    }


    public function testBackOfficeTitle()
    {
        $this->url('/_admin/');

        $this->assertContains('Administration panel', $this->title());
    }

    public function testLoginFormExists()
    {
        $this->url('/_admin/');

        $email = $this->byName('email');
        $passwd = $this->byName('passwd');
        $submit = $this->byName('submitLogin');
    }

    public function testAdminLogin()
    {
        $this->doAdminLogin('test@example.com', '0123456789');
    }

    public function testModuleInstall()
    {
        $this->doAdminLogin('test@example.com', '0123456789');
        
        $this->tokenUrl('/_admin/index.php?controller=AdminModules');
        $this->assertContains('Modules', $this->title());

        $this->byXpath('(//a[contains(@data-module-name, \'zzcleanurls\')])')->click();
        $this->byId('proceed-install-anyway')->click();

        $this->assertContains('configure=zzcleanurls', $this->url());
        $this->assertTextPresent('Module(s) installed successfully');
    }
}
