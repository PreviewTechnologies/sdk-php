<?php
/**
 * Write something about the purpose of this file
 *
 * @author Shaharia Azam <shaharia@previewtechs.com>
 * @url https://www.previewtechs.com
 */

namespace Previewtechs\SDK\Tests\Core;

use Previewtechs\SDK\Core\Client;
use Previewtechs\SDK\Services\MailServices\Mailer;

/**
 * Class ClientTests
 * @package Previewtechs\SDK\Tests\Core
 */
class ClientTests extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     *
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     *
     */
    public function testInstantiateClient()
    {
        $client = new Client(['auth' => ['api_key' => 'api_key_value']]);
        $this->assertTrue($client instanceof Client);
        $this->assertNotEmpty($client->getOptions());
        $this->assertTrue($client->getMailServices() instanceof Mailer);
    }

    /**
     *
     */
    public function testSetOptions()
    {
        $client = new Client();
        $client->setOptions(['key' => 'value']);
        $this->assertEquals('value', $client->getOptions("key"));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetOptionsWithExistedKeyShouldReturnException()
    {
        $client = new Client();
        $client->addOptions('key', 'value');
        $client->addOptions('key', 'differentValue');
        $this->assertEquals('value', $client->getOptions("key"));
    }
    public function testAddOptionSets()
    {
        $client = new Client();
        $client->addOptions('key', 'value');
        $this->assertEquals('value', $client->getOptions("key"));
    }

    public function testHttpClientAttachment()
    {
        $client = new Client();
        $client->setHttp(new \GuzzleHttp\Client());

        $this->assertTrue($client->getHttp() instanceof \GuzzleHttp\Client);
    }

    public function testJsonMapperDependency()
    {
        $client = new Client();
        $this->assertTrue($client->getJsonMapper() instanceof \JsonMapper);

        $client->setJsonMapper(new \JsonMapper());
        $this->assertTrue($client->getJsonMapper() instanceof \JsonMapper);
    }
}