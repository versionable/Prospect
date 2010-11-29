<?php

namespace Versionable\HttpClient\Request;

use Versionable\HttpClient\Url\UrlInterface;
use Versionable\HttpClient\Cookie\Collection as CookieCollectionInterface;
use Versionable\HttpClient\Header\Collection as HeaderCollectionInterface;
use Versionable\HttpClient\Parameter\Collection as ParameterCollectionInterface;

class Request implements RequestInterface
{
  protected $url = null;

  protected $method = 'GET';

  protected $headers = array();

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

  public function getMethod() {
    return $this->method;
  }

  public function getHeaders() {
    return $this->headers;
  }

  public function setHeaders(HeaderCollectionInterface $headers) {
    $this->headers = $headers;
  }

  public function hasCookies() {
    return (is_null($cookies) && count($this->cookies) > 0);
  }

  public function getCookies() {
    return $this->cookies;
  }

  public function setCookies(CookieCollectionInterface $collection) {
    $this->cookies = $collection;
  }

  public function setMethod($method) {

    if(in_array($method,array('GET', 'POST', 'PUT', 'DELETE')))
    {
      $this->method = $method;

      return true;
    }

    return false;
  }
  
  public function getUserAgent() {
    return $this->agent;
  }

  public function setUserAgent(UserAgentInteface $agent) {
    $this->agent = $agent;
  }



}