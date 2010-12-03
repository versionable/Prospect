<?php

namespace Versionable\Http\Request;

use Versionable\Http\Url\UrlInterface;
use Versionable\Http\Cookie\CollectionInterface as CookieCollectionInterface;
use Versionable\Http\Header\CollectionInterface as HeaderCollectionInterface;
use Versionable\Http\Parameter\CollectionInterface as ParameterCollectionInterface;

class Request implements RequestInterface
{
  protected $url = null;

  protected $method = 'GET';

  protected $headers = null;

  protected $cookies = null;

  protected $parameters = null;
  
  protected $agent = null;

  public function setUrl(UrlInterface $url) {
    $this->url = $url;
  }
  public function getUrl() {
    return $this->url;
  }

  public function setParameters(ParameterCollectionInterface $parameters) {
    $this->parameters = $parameters;
  }

  public function getParameters() {
    return $this->parameters;
  }
  
  public function hasParameters() {
    return !\is_null($this->parameters);
  }

  public function getMethod() {
    return $this->method;
  }

  public function getHeaders() {
    return $this->headers;
  }

  public function setHeaders(HeaderCollectionInterface $headers) {
    $this->headers = $headers;
  }
  
  public function hasHeaders() {
    return !\is_null($this->headers);
  }

  public function hasCookies() {
    return !\is_null($this->cookies);
  }

  public function getCookies() {
    return $this->cookies;
  }

  public function setCookies(CookieCollectionInterface $collection) {
    $this->cookies = $collection;
  }

  public function setMethod($method) {

    if (in_array($method,array('GET', 'POST', 'PUT', 'DELETE')))
    {
      $this->method = $method;

      return true;
    }

    return false;
  }
}