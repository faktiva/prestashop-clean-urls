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

    public function testSubmitToSelf()
    {
        $this->url('/_admin/');

        // create a form object for reuse
        $form = $this->byId('login_form');

        // get the form action
        $action = $form->attribute('action');

        // fill in the form field values
        $this->byName('email')->value('test@example.com');
        $this->byName('passwd')->value('0123456789');

        // submit the form
        $form->submit();

        // check if form was posted
        $success = $this->byCssSelector('body')->text();

        // check the value
        $this->assertContains('Dashboard', $success);
    }
}
