<?php

require_once __DIR__.'/../../vendor/autoload.php';

require_once __DIR__.'/../../../../config/config.inc.php';
require_once __DIR__.'/../../../../classes/Tab.php';
require_once __DIR__.'/../../../../classes/Tools.php';

class BackOfficeTest extends Sauce\Sausage\WebDriverTestCase
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

    protected static function getAdminToken($controller_name, $employee_id=1)
    {
        $str = $controller_name
            . (int)Tab::getIdFromClassName($controller_name)
            . (int)$employee_id;

        return Tools::getAdminToken($str);
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

        $this->url('/_admin/index.php?controller=AdminModules&token='.self::getAdminToken('AdminModules'));
        $this->assertContains('Modules', $this->title());

        $this->byXpath('(//a[contains(@data-module-name, \'zzcleanurls\')])')->click();
        $this->byId('proceed-install-anyway')->click();

        $this->assertContains('configure=zzcleanurls', $this->url());
        $this->assertTextPresent('Module(s) installed successfully');
    }
}
