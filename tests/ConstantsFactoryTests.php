<?php
/**
 * Write something about the purpose of this file
 *
 * @author Shaharia Azam <shaharia@previewtechs.com>
 * @url https://www.previewtechs.com
 */

namespace Previewtechs\SDK\Tests;

use Previewtechs\SDK\ConstantsFactory;

class ConstantsFactoryTests extends \PHPUnit_Framework_TestCase
{
    public function testConstants()
    {
        $cfactory = new ConstantsFactory();
        $this->assertNotEmpty($cfactory::API_VERSION_STABLE);
    }

    public function testStoreConstant()
    {
        $cfactory = new ConstantsFactory();
        $cfactory->testKey = "testValue";

        $this->assertTrue(in_array('testValue', $cfactory->getConstants()));
    }
}
