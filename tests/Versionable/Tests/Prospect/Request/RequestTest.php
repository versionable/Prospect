<?php

namespace Versionable\Tests\Prospect\Request;

use Versionable\Prospect\Request\Request;
use Versionable\Prospect\Parameter\Parameter;
use Versionable\Prospect\File\File;

/**
 * Test class for Request.
 * Generated by PHPUnit on 2011-01-23 at 15:34:14.
 */
class RequestTest extends \PHPUnit_Framework_TestCase
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
        $this->object = new Request;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
    
    public function testConstruct()
    {
      $url = $this->getMock('Versionable\Prospect\Url\UrlInterface', array(), array('http://testing.com'));
      $this->object = new Request($url);
      $this->assertEquals($this->readAttribute($this->object, 'url'), $url);
    }

    /**
     * @todo Implement testSetUrl().
     */
    public function testSetUrl()
    {
      $url = $this->getMock('Versionable\Prospect\Url\UrlInterface', array(), array('http://testing.com'));
      $this->object->setUrl($url);
      $this->assertEquals($this->readAttribute($this->object, 'url'), $url);
    }

    /**
     * @todo Implement testGetUrl().
     */
    public function testGetUrl()
    {
      $url = $this->getMock('Versionable\Prospect\Url\UrlInterface', array(), array('http://testing.com'));
      $this->object->setUrl($url);
      $this->assertEquals($this->readAttribute($this->object, 'url'), $this->object->getUrl());
    }

    /**
     * @todo Implement testHasBody().
     */
    public function testHasBody()
    {
      $this->assertFalse($this->object->hasBody());
      
      $this->object->setBody('some body');

      $this->assertTrue($this->object->hasBody());
    }

    /**
     * @todo Implement testGetBody().
     */
    public function testGetBody()
    {
      $this->object->setBody('body');
      $body = $this->readAttribute($this->object, 'body');
      
      $this->assertEquals($body, $this->object->getBody());
    }

    /**
     * @todo Implement testSetBody().
     */
    public function testSetBody()
    {
      $text = 'some text';
      $this->object->setBody($text);
      $body = $this->readAttribute($this->object, 'body');
      $this->assertEquals($text, $body);

    }

    /**
     * @todo Implement testSetParameters().
     */
    public function testSetParameters()
    {
      $parameters = $this->getMock('Versionable\Prospect\Parameter\CollectionInterface');
      $this->object->setParameters($parameters);
      $this->assertEquals($parameters, $this->readAttribute($this->object, 'parameters'));
    }

    /**
     * @todo Implement testGetParameters().
     */
    public function testGetParameters()
    {
      $parameters = $this->getMock('Versionable\Prospect\Parameter\CollectionInterface');
      $this->object->setParameters($parameters);
      $this->assertEquals($this->object->getParameters(), $this->readAttribute($this->object, 'parameters'));
    }


    /**
     * @todo Implement testSetFiles().
     */
    public function testSetFiles()
    {
      $files = $this->getMock('Versionable\Prospect\File\CollectionInterface');
      $this->object->setFiles($files);
      $this->assertEquals($files, $this->readAttribute($this->object, 'files'));
    }

    /**
     * @todo Implement testGetFiles().
     */
    public function testGetFiles()
    {
      $files = $this->getMock('Versionable\Prospect\File\CollectionInterface');
      $this->object->setFiles($files);
      $this->assertEquals($this->object->getFiles(), $this->readAttribute($this->object, 'files'));
    }

    /**
     * @todo Implement testGetMethod().
     */
    public function testGetMethod()
    {
      $method = 'DELETE';
      $this->object->setMethod($method);
      $this->assertEquals($method, $this->readAttribute($this->object, 'method'));
    }
    
    public function testSetMethod()
    {
      $method = 'POST';
      $this->object->setMethod($method);
      $this->assertEquals($method, $this->object->getMethod());
    }
    
    public function testSetMethodInvalid()
    {
      $method = 'INVALID';
      $this->setExpectedException('\InvalidArgumentException');
      $this->object->setMethod($method);
    }

    public function testSetHeaders()
    {
      $headers = $this->getMock('Versionable\Prospect\Header\CollectionInterface');
      $this->object->setHeaders($headers);
      $this->assertEquals($headers, $this->readAttribute($this->object, 'headers'));
    }
    
    public function testGetHeaders()
    {
      $headers = $this->getMock('Versionable\Prospect\Header\CollectionInterface');
      $this->object->setHeaders($headers);
      $this->assertEquals($this->object->getHeaders(), $this->readAttribute($this->object, 'headers'));
    }

    public function testSetCookies()
    {
      $cookies = $this->getMock('Versionable\Prospect\Cookie\CollectionInterface');
      $this->object->setCookies($cookies);
      $this->assertEquals($cookies, $this->readAttribute($this->object, 'cookies'));
    }
    
    public function testGetCookies()
    {
      $cookies = $this->getMock('Versionable\Prospect\Cookie\CollectionInterface');
      $this->object->setCookies($cookies);
      $this->assertEquals($this->object->getCookies(), $this->readAttribute($this->object, 'cookies'));
    }   

    /**
     * @todo Implement testGetPort().
     */
    public function testGetPort()
    {
      $this->object->setPort(8080);
      $this->assertEquals($this->readAttribute($this->object, 'port'), $this->object->getPort());
    }
    
    public function testGetPortWithUrl()
    {
      $port = 10000;
      $url = $this->getMock('Versionable\Prospect\Url\UrlInterface', array(), array('http://testing.com'));
      $url->expects($this->any())->method('getPort')->will($this->returnValue($port));
      $this->object->setUrl($url);
      $this->assertEquals($port, $this->object->getPort());
    }

    /**
     * @todo Implement testSetPort().
     */
    public function testSetPort()
    {
      $port = 8080;
      $this->object->setPort($port);
      $this->assertEquals($port, $this->readAttribute($this->object, 'port'));
    }

    /**
     * @todo Implement testGetVersion().
     */
    public function testGetVersion()
    {
      $this->object->setVersion(1.1);
      $this->assertEquals($this->readAttribute($this->object, 'version'), $this->object->getVersion());
    }

    /**
     * @todo Implement testSetVersion().
     */
    public function testSetVersion()
    {
      $version = 1.1;
      $this->object->setVersion($version);
      $this->assertEquals($version, $this->readAttribute($this->object, 'version'));
    }

    public function testIsMultiPartFalseOnlyBody()
    {
        $this->object->setBody('some body');
        $this->assertFalse($this->object->isMultipart());
    }
    
    public function testIsMultiPartFalseHasContentBody()
    {
        $this->object->setBody('some body');
        $this->assertFalse($this->object->isMultipart());
    }
    
    public function testIsMultiPartFalseHasContentAndFilesButBodyNotSupported()
    {
        $this->object->setBody('some body');
        $this->object->getFiles()->add(new File('test', 'test.txt', 'text/plain'));
        
        $this->assertFalse($this->object->isMultipart());
    }
    
    public function testIsMultiPartFalseHasContentAndFilesAndBodySupported()
    {
        $this->object->setMethod('POST');
        $this->object->setBody('some body');
        $this->object->getFiles()->add(new File('test', 'test.txt', 'text/plain'));
        
        $this->assertTrue($this->object->isMultipart());
    }
}
