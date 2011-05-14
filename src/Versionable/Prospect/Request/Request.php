<?php

namespace Versionable\Prospect\Request;

use Versionable\Prospect\Url\UrlInterface;
use Versionable\Prospect\Cookie\CollectionInterface as CookieCollectionInterface;
use Versionable\Prospect\File\CollectionInterface as FileCollectionInterface;
use Versionable\Prospect\Header\CollectionInterface as HeaderCollectionInterface;
use Versionable\Prospect\Parameter\CollectionInterface as ParameterCollectionInterface;


//use Versionable\Prospect\Cookie\Collection as CookieCollection;
//use Versionable\Prospect\File\Collection as FileCollection;
//use Versionable\Prospect\Header\Collection as HeaderCollection;
//use Versionable\Prospect\Parameter\Collection as ParameterCollection;

class Request implements RequestInterface
{
  protected $url = null;

  protected $port = 80;

  protected $method = 'GET';

  protected $headers = null;

  protected $cookies = null;

  protected $parameters = null;

  protected $files = null;

  protected $body = '';

  protected $version = 1.1;
  
  protected $parts = array();
  
  protected $stringBuilder = null;

  public function __construct(UrlInterface $url = null)
  {
    if (!is_null($url))
    {
      $this->setUrl($url);
    }

    $this->cookies = new \Versionable\Prospect\Cookie\Collection();
    $this->files = new \Versionable\Prospect\File\Collection();
    $this->headers = new \Versionable\Prospect\Header\Collection();
    $this->parameters = new \Versionable\Prospect\Parameter\Collection();
  }

  /**
   *
   * @param UrlInterface $url
   */
  public function setUrl(UrlInterface $url)
  {
    $this->url = $url;
  }

  /**
   *
   * @return UrlInterface
   */
  public function getUrl()
  {
    return $this->url;
  }

  /**
   * Returns whether the body has been set
   *
   * @return boolean
   */
  public function hasBody()
  {
    return $this->getBody() != '';
  }

  /**
   * Returns the body
   *
   *
   * @return string
   */
  public function getBody()
  {
    return $this->body;
  }

  public function setBody($body)
  {
    $this->body = $body;
  }

  public function setParameters(ParameterCollectionInterface $parameters)
  {
    $this->parameters = $parameters;
  }

  public function getParameters()
  {    
    return $this->parameters;
  }

  public function setFiles(FileCollectionInterface $files)
  {
    $this->files = $files;
  }

  public function getFiles()
  {    
    return $this->files;
  }

  public function getMethod()
  {
    return $this->method;
  }

  public function getHeaders()
  {    
    return $this->headers;
  }

  public function setHeaders(HeaderCollectionInterface $headers)
  {
    $this->headers = $headers;
  }

  public function getCookies()
  {    
    return $this->cookies;
  }

  public function setCookies(CookieCollectionInterface $collection)
  {
    $this->cookies = $collection;
  }

  public function setMethod($method)
  {

    if (in_array($method,array('HEAD', 'GET', 'POST', 'PUT', 'DELETE')))
    {
      $this->method = $method;

      return true;
    }

    throw new \InvalidArgumentException('Invalid HTTP method');
  }

  public function getPort()
  {
    if (false == is_null($this->url) && is_numeric($this->getUrl()->getPort())) {
      return $this->getUrl()->getPort();
    }

    return $this->port;
  }

  public function setPort($port)
  {
    $this->port = $port;
  }

  public function getVersion()
  {
    return $this->version;
  }

  public function setVersion($version)
  {
    $this->version = $version;
  }
  
  public function isMultipart()
  {
    if (($this->hasBody() || !$this->getParameters()->isEmpty()) && !$this->getFiles()->isEmpty() && $this->isBodySupported())
    {
      return true;
    }

    return false;
  }
 

  protected function isBodySupported()
  {
    if (in_array($this->getMethod(), array('POST', 'PUT')))
    {
      return true;
    }
    
    return false;
  }
}
