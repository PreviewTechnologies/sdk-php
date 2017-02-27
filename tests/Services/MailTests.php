<?php
/**
 * Write something about the purpose of this file
 *
 * @author Shaharia Azam <shaharia@previewtechs.com>
 * @url https://www.previewtechs.com
 */

namespace Previewtechs\SDK\Tests\Services;

use Previewtechs\SDK\Http\Agent;
use Previewtechs\SDK\Services\Mail;
use Previewtechs\SDK\Tests\MockObjects\Client;

/**
 * Class MailTests
 * @package Previewtechs\SDK\Tests\Services
 */
class MailTests extends \PHPUnit_Framework_TestCase
{
    /**
     * @var
     */
    protected $mockClient;
    protected $mockHttpAgent;

    /**
     *
     */
    public function setUp()
    {
        $mockClient = new Client();
        $this->mockClient = $mockClient->getMock();

        $this->mockHttpAgent = \Mockery::mock('Previewtechs\SDK\Http\Agent');
        $this->mockHttpAgent->shouldReceive();

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
    public function testInstantiate()
    {
        $mail = new Mail($this->mockClient);
        $this->assertTrue($mail->send() instanceof Agent);
    }
}
