<?php
/**
 * Write something about the purpose of this file
 *
 * @author Shaharia Azam <shaharia@previewtechs.com>
 * @url https://www.previewtechs.com
 */

namespace Previewtechs\SDK\Tests;


use Previewtechs\SDK\Client;
use Previewtechs\SDK\Services\Mail;

/**
 * Class ClientTests
 * @package Previewtechs\SDK\Tests
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
        $client = new Client();
        $this->assertTrue($client instanceof Client);
        $this->assertEmpty($client->getOptions());
        $this->assertTrue($client->getMailServices() instanceof Mail);
    }

    /**
     *
     */
    public function testAddOptionSets()
    {
        $client = new Client();
        $client->setOptions("key", 'value');
        $client->setOptions("anotherKey", "anotherValue");

        $this->assertEquals('value', $client->getOptions("key"));
    }
}