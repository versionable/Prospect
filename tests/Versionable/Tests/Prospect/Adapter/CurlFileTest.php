<?php

namespace Versionable\Prospect\Adapter;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2012-09-12 at 11:49:49.
 */
class CurlFileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var CurlFile
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new CurlFile;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers Versionable\Prospect\Adapter\CurlFile::initialize
     */
    public function testInitialize()
    {
        $this->object->initialize();

        $this->assertAttributeInternalType('resource', 'handle', $this->object);
    }

    /**
     * @covers Versionable\Prospect\Adapter\CurlFile::call
     * @todo   Implement testCall().
     */
    public function testCall()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}
