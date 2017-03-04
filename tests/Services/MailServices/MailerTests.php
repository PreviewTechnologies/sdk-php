<?php

namespace Previewtechs\SDK\Tests\Services\MailServices;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Previewtechs\SDK\Client;
use Previewtechs\SDK\Services\MailServices\Mailer;
use Previewtechs\SDK\Services\MailServices\Response\GeneralResponse;

class MailerTests extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var Mailer
     */
    protected $mailer;

    protected $mailerData = [
        'mock_to' => ["Mockery <mock@mockemail.com>", "Mockery Additional <mock_additional@mockemail.com>"],
        'mock_from' => 'Mock Sender <sender@mock.com>',
        'mock_subject' => 'Mock Subject',
        'mock_html_body' => '<strong>Mock Html Body</strong>',
        'mock_text_body' => 'Mock Text Body',
    ];

    public function setUp()
    {
        $this->client = new Client(['auth' => ['api_key' => 'mock_api_key']]);
        $mockHttpHandler = new MockHandler([
            new Response(200, []),
            new Response(200, [])
        ]);
        $handler = HandlerStack::create($mockHttpHandler);
        $httpClient = new \GuzzleHttp\Client(['handler' => $handler]);
        $this->client->setHttp($httpClient);
        $this->mailer = $this->client->getMailServices();

        parent::setUp();
    }

    public function tearDown()
    {
        $this->client = null;
        unset($this->mailer);
        parent::tearDown();
    }

    public function testInstantiateMailerClass()
    {
        $this->assertTrue($this->client->getMailServices() instanceof Mailer);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMailerClassWithoutApiKey()
    {
        $client = new Client();
        $client->getMailServices();
    }

    /**
     *
     */
    public function testMailServicesApiEndpoint()
    {
        $mailer = $this->mailer;
        $exists = strpos($mailer::MAIL_SERVICES_ENDPOINT, "https://mail-services.previewtechsapis.com/");
        $this->assertEquals(0, $exists);
    }

    public function testApiPostParams()
    {
        $this->mailer->setTo($this->mailerData['mock_to']);
        $this->mailer->setFrom($this->mailerData['mock_from']);
        $this->mailer->setSubject($this->mailerData['mock_subject']);
        $this->mailer->setHtmlBody($this->mailerData['mock_html_body']);
        $this->mailer->setTextBody($this->mailerData['mock_text_body']);
        $this->mailer->addCustomVars('o:tag', "Mock Tag");
        $params = $this->mailer->getParams();
        $this->assertTrue(is_array($params));
        $this->assertEquals($this->mailerData['mock_to'][0], $params['to'][0]);
        $this->assertEquals($this->mailerData['mock_from'], $params['from']);
        $this->assertEquals($this->mailerData['mock_subject'], $params['subject']);
        $this->assertEquals($this->mailerData['mock_html_body'], $params['html']);
        $this->assertEquals($this->mailerData['mock_text_body'], $params['text']);
    }

    public function testAddingMultipleReceipients()
    {
        $this->mailer->addTo("mockemail@example.com", "Mock Receipients 1");
        $this->mailer->addTo("mockemail2@example.com", "Mock Receipients 2");
        $this->assertTrue(is_array($this->mailer->getTo()) && sizeof($this->mailer->getTo() === 2));
        $this->assertEquals("Mock Receipients 1 <mockemail@example.com>", $this->mailer->getTo()[0]);
        $this->assertEquals("Mock Receipients 2 <mockemail2@example.com>", $this->mailer->getTo()[1]);

        $this->mailer->setTo($this->mailerData['mock_to']);
        $this->assertEquals($this->mailerData['mock_to'][0], $this->mailer->getTo()[0]);
        $this->assertEquals($this->mailerData['mock_to'][1], $this->mailer->getTo()[1]);
    }

    public function testSetCustomVariables()
    {
        $this->mailer->setCustomVars(['o:tag' => 'tag value']);
        $this->mailer->addCustomVars("anothertag", "anothertagvalue");
        $this->assertTrue(2 === sizeof($this->mailer->getCustomVars()));
        $this->assertEquals("tag value", $this->mailer->getCustomVars()['o:tag']);
        $this->assertEquals("anothertagvalue", $this->mailer->getCustomVars()['anothertag']);
    }

    public function testSendMailSuccessfully()
    {
        $mockHttpHandler = new MockHandler([
            new Response(200, [], json_encode(array(
                'success' => true,
                'message' => 'Mail sent successfully',
                'data' =>
                    array(
                        'email_id' => '<mockmailid@mailsrv-a.previewtechs.com>',
                        'result_text' => 'Queued. Thank you.',
                    ),
            ))),
            new Response(200, [])
        ]);
        $handler = HandlerStack::create($mockHttpHandler);
        $httpClient = new \GuzzleHttp\Client(['handler' => $handler]);
        $this->client->setHttp($httpClient);
        $this->mailer = $this->client->getMailServices();

        $this->mailer->addTo("mockemail@example.com", "Mockery");
        $this->mailer->setFrom($this->mailerData['mock_from']);
        $this->mailer->setSubject($this->mailerData['mock_subject']);
        $this->mailer->setHtmlBody($this->mailerData['mock_html_body']);
        $this->mailer->setTextBody($this->mailerData['mock_text_body']);
        $this->mailer->addCustomVars('o:tag', "Mock Tag");
        $response = $this->mailer->send();
        $this->assertTrue(is_object($response));
        $this->assertTrue($response instanceof GeneralResponse);

        $this->assertNotEmpty($response->getData()->getMessageId());
        $this->assertEquals("<mockmailid@mailsrv-a.previewtechs.com>", $response->getData()->getMessageId());
        $this->assertEquals(true, $response->isSuccess());
        $this->assertEquals("Mail sent successfully", $response->getMessage());

        $this->assertTrue($this->mailer->getResponse() instanceof GeneralResponse);
    }

    public function testSendMailInvalidAuthorizationError()
    {
        $mockHttpHandler = new MockHandler([
            new Response(200, [], json_encode(array(
                'success' => false,
                'message' => 'Invalid Authorization',
                'error' => 'InvalidCredentials',
                'errorCode' => 101001,
            ))),
            new Response(200, [])
        ]);
        $handler = HandlerStack::create($mockHttpHandler);
        $httpClient = new \GuzzleHttp\Client(['handler' => $handler]);
        $this->client->setHttp($httpClient);
        $this->mailer = $this->client->getMailServices();

        $this->mailer->addTo("mockemail@example.com", "Mockery");
        $this->mailer->setFrom($this->mailerData['mock_from']);
        $this->mailer->setSubject($this->mailerData['mock_subject']);
        $this->mailer->setHtmlBody($this->mailerData['mock_html_body']);
        $this->mailer->setTextBody($this->mailerData['mock_text_body']);
        $this->mailer->addCustomVars('o:tag', "Mock Tag");
        $response = $this->mailer->send();
        $this->assertTrue(is_object($response));
        $this->assertTrue($response instanceof GeneralResponse);

        $this->assertTrue(false === $response->isSuccess());
        $this->assertEquals("Invalid Authorization", $response->getMessage());
        $this->assertEquals("InvalidCredentials", $response->getError());
        $this->assertEquals(101001, $response->getErrorCode());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIfNoRecipient()
    {
        $this->mailer->setFrom($this->mailerData['mock_from']);
        $this->mailer->setSubject($this->mailerData['mock_subject']);
        $this->mailer->setHtmlBody($this->mailerData['mock_html_body']);
        $this->mailer->setTextBody($this->mailerData['mock_text_body']);
        $this->mailer->addCustomVars('o:tag', "Mock Tag");
        $this->mailer->send();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIfNoSender()
    {
        $this->mailer->addTo("mockemail@example.com", "Mockery");
        $this->mailer->setSubject($this->mailerData['mock_subject']);
        $this->mailer->setHtmlBody($this->mailerData['mock_html_body']);
        $this->mailer->setTextBody($this->mailerData['mock_text_body']);
        $this->mailer->addCustomVars('o:tag', "Mock Tag");
        $this->mailer->send();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIfNoSubject()
    {
        $this->mailer->setFrom($this->mailerData['mock_from']);
        $this->mailer->addTo("mockemail@example.com", "Mockery");
        $this->mailer->setHtmlBody($this->mailerData['mock_html_body']);
        $this->mailer->setTextBody($this->mailerData['mock_text_body']);
        $this->mailer->addCustomVars('o:tag', "Mock Tag");
        $this->mailer->send();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIfNoHtmlBody()
    {
        $this->mailer->setFrom($this->mailerData['mock_from']);
        $this->mailer->addTo("mockemail@example.com", "Mockery");
        $this->mailer->setSubject($this->mailerData['mock_subject']);
        $this->mailer->setTextBody($this->mailerData['mock_text_body']);
        $this->mailer->addCustomVars('o:tag', "Mock Tag");
        $this->mailer->send();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIfNoTextBody()
    {
        $this->mailer->setFrom($this->mailerData['mock_from']);
        $this->mailer->addTo("mockemail@example.com", "Mockery");
        $this->mailer->setSubject($this->mailerData['mock_subject']);
        $this->mailer->setHtmlBody($this->mailerData['mock_html_body']);
        $this->mailer->addCustomVars('o:tag', "Mock Tag");
        $this->mailer->send();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIfRecipientDataMalformed()
    {
        $this->mailer->setTo("Test");
        $this->mailer->setFrom($this->mailerData['mock_from']);
        $this->mailer->setSubject($this->mailerData['mock_subject']);
        $this->mailer->setHtmlBody($this->mailerData['mock_html_body']);
        $this->mailer->setTextBody($this->mailerData['mock_text_body']);
        $this->mailer->addCustomVars('o:tag', "Mock Tag");
        $this->mailer->send();
    }
}