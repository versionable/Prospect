<?php

namespace Versionable\Tests\Prospect\Request;

use Versionable\Prospect\Request\SoapRequest;

/**
 * Test class for Request.
 * Generated by PHPUnit on 2011-01-23 at 15:34:14.
 */
class SoapRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Request
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new SoapRequest;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
    
    /**
     * @todo Implement testSetXmls().
     */
    public function testSetXmls()
    {
        $url = 'someXmls';
        $this->object->setXmls($url);
        $this->assertEquals($this->readAttribute($this->object, 'xmls'), $url);
    }

    /**
     * @todo Implement testGetXmls().
     */
    public function testGetXmls()
    {
        $this->assertEquals($this->readAttribute($this->object, 'xmls'), $this->object->getUrl());
    }
}
