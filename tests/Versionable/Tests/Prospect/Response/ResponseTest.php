<?php

namespace Versionable\Tests\Prospect\Response;

use Versionable\Prospect\Response\Response;

/**
 * Test class for Response.
 * Generated by PHPUnit on 2011-04-02 at 15:55:35.
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Response
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Response;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
    
    public function testParse()
    {
      $string = file_get_contents(__DIR__ . '/../../../../data/response/complete.txt');
      $content = file_get_contents(__DIR__ . '/../../../../data/response/content.txt');
      
      $this->object->parse($string);
      
      $this->assertEquals(200, $this->object->getCode());
      $this->assertEquals($content, $this->object->getContent());
      
      $headers = $this->object->getHeaders();
      
      $this->assertEquals('nginx/0.7.67', $headers->get('Server')->getValue());
      $this->assertEquals('Wed, 13 Apr 2011 20:19:22 GMT', $headers->get('Date')->getValue());
      $this->assertEquals('text/html; charset=UTF-8', $headers->get('Content-Type')->getValue());
      $this->assertEquals('chunked', $headers->get('Transfer-Encoding')->getValue());
      $this->assertEquals('close', $headers->get('Connection')->getValue());
      $this->assertEquals('no-cache', $headers->get('Cache-Control')->getValue());
      
      $cookies = $this->object->getCookies();
      $this->assertTrue($cookies->containsKey('_SESS'));
    }

    /**
     * @todo Implement testGetCode().
     */
    public function testGetCode()
    {
      $this->object->setCode(418);
      $this->assertEquals($this->readAttribute($this->object, 'code'), $this->object->getCode());
    }

    /**
     * @todo Implement testSetCode().
     */
    public function testSetCode()
    {
      $code = 200;
      $this->object->setCode($code);
      $this->assertEquals($code, $this->readAttribute($this->object, 'code'));
    }
    
    public function testSetCodeInvalid()
    {
      $this->setExpectedException('\InvalidArgumentException');
      $code = 999;
      $this->object->setCode($code);
    }

    /**
     * @todo Implement testGetContent().
     */
    public function testGetContent()
    {
      $content = "Some content";
      $this->object->setContent($content);
      $this->assertEquals($content, $this->object->getContent());
    }

    /**
     * @todo Implement testSetContent().
     */
    public function testSetContent()
    {
      $content = "Some content";
      $this->object->setContent($content);
      $this->assertEquals($content, $this->readAttribute($this->object, 'content'));
    }

    public function testGetHeaders()
    {
      $headers = $this->getMock('Versionable\Prospect\Header\CollectionInterface');
      $this->object->setHeaders($headers);
      $this->assertEquals($headers, $this->object->getHeaders());
    }

    public function testSetHeaders()
    {
      $headers = $this->getMock('Versionable\Prospect\Header\CollectionInterface');
      $this->object->setHeaders($headers);
      $this->assertEquals($headers, $this->readAttribute($this->object, 'headers'));
    }
    
    public function testGetCookies()
    {
      $cookies = $this->getMock('Versionable\Prospect\Cookie\CollectionInterface');
      $this->object->setCookies($cookies);
      $this->assertEquals($cookies, $this->object->getCookies());
    }

    public function testSetCookies()
    {
      $cookies = $this->getMock('Versionable\Prospect\Cookie\CollectionInterface');
      $this->object->setCookies($cookies);
      $this->assertEquals($cookies, $this->readAttribute($this->object, 'cookies'));
    }
}
