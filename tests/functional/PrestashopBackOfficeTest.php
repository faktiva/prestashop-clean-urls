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

    public function setUp()
    {
        $this->timeouts()->implicitWait(10000);
        $this->timeouts()->asyncScript(10000);
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

        $this->assertEquals('', $email->value());
        $this->assertEquals('', $passwd->value());
    }

    public function testAdminLogin()
    {
        $this->doAdminLogin('test@example.com', '0123456789');
    }

    public function testModuleInstall()
    {
        $this->doAdminLogin('test@example.com', '0123456789');

        $this->click('//li[@id=\'subtab-AdminModules\']/a');
        $this->assertContains('Modules', $this->title());

        $this->click('xpath=(//a[contains(@data-module-name, \'zzcleanurls\')])');
        $this->click('id=proceed-install-anyway');
        $this->assertContains('Modules', $this->title());
        $this->assertContains('configure=zzcleanurls', $this->url());
    }
}
