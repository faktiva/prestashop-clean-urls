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
        $this->url('/_admin/');

        $this->byName('email')->value('test@example.com');
        $this->byName('passwd')->value('0123456789');
        $this->byId('login_form')->submit();

        $this->assertContains('Dashboard', $this->byCssSelector('body')->text());
    }

    public function testModuleInstall()
    {
        $this->url('/_admin/');
        $this->assertTrue($this->isElementPresent('id=login'));
        $this->type('id=email', 'test@example.com');
        $this->type('id=passwd', '0123456789');
        $this->click('name=submitLogin');
        $this->waitForPageToLoad(30000);

        $this->click('//li[@id=\'subtab-AdminModules\']/a');
        $this->waitForPageToLoad(30000);
        $this->assertContains('Modules', $this->getTitle());

        $this->click('xpath=(//a[contains(@data-module-name, \'zzcleanurls\')])');
        $this->click('id=proceed-install-anyway');
        $this->waitForPageToLoad(30000);
        $this->assertTrue((bool)preg_match('/^Modules[\s\S]*$/', $this->getTitle()));
        $this->assertContains('configure=zzcleanurls', $this->getLocation());
    }
}
