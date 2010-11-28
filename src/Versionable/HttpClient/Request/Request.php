<?php

namespace Versionable\HttpClient\Request;

use Versionable\HttpClient\Cookie\Collection as CookieCollectionInterface;
use Versionable\HttpClient\Header\Collection as HeaderCollectionInterface;
use Versionable\HttpClient\Url\UrlInterface;
use Versionable\HttpClient\File\FileInterface;

class Request implements RequestInterface
{
  protected $url = null;

  protected $method = 'GET';

  protected $headers = array();

  protected $cookies = null;

  protected $parameter = array();

  protected $files = array();
  
  protected $agent = null;

  public function setUrl(UrlInterface $url) {
    $this->url = $url;
  }
  public function getUrl() {
    return $this->url;
  }

  public function setParameters(array $parameters) {
    if (\is_array($parameters)) {
      $this->parameter = $parameters;

      return true;
    }

    return false;
  }

  public function getParameter($name) {
    if ($this->hasParameter($name)) {
      return $this->parameter[$name];
    }

    return null;
  }

  public function setParameter($name, $value) {
    $this->parameter[$name] = $value;
  }

  public function hasParameter($name) {
    return isset($this->parameter[$name]);
  }

  public function getParameters() {
    return $this->parameter;
  }

  public function addFile($name, FileInterface $file) {
    if (\file_exists($file->getFilename())) {
      $this->files[$name] = $file;

      return true;
    }

    return false;
  }

  public function getFiles() {
    return $this->files;
  }

  public function setFiles($files) {
    $this->files = $files;
  }

  public function hasFiles() {
    return !empty($this->files);
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