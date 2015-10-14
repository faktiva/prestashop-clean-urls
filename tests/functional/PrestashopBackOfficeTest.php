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
        $this->byId('login_form')->submit();

        $this->assertTextPresent('Dashboard', $this->byCss('body'));
    }

    protected function doLogout()
    {
        $this->url('/_admin/index.php?controller=AdminLogin&logout');
        $this->assertTextPresent('Logged out');
    }

    public function setUpPage()
    {
        $this->timeouts()->implicitWait(10000);
        $this->timeouts()->asyncScript(10000);

        $this->url($this->base_url);
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
        $this->assertTrue((bool)preg_match('/^Modules[\s\S]*$/', $this->title()));
        $this->assertContains('configure=zzcleanurls', $this->location());
    }
}
