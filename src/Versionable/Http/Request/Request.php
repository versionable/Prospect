<?php

namespace Versionable\Http\Request;

use Versionable\Http\Url\UrlInterface;
use Versionable\Http\Cookie\CollectionInterface as CookieCollectionInterface;
use Versionable\Http\Header\CollectionInterface as HeaderCollectionInterface;
use Versionable\Http\Parameter\CollectionInterface as ParameterCollectionInterface;
use Versionable\Http\File\CollectionInterface as FileCollectionInterface;

class Request implements RequestInterface
{
  protected $url = null;
  
  protected $port = null;

  protected $method = 'GET';

  protected $headers = null;

  protected $cookies = null;

  protected $parameters = null;
  
  protected $files = null;
  
  protected $body = '';

  protected $version = 1.1;
  
  public function __construct() {
    $this->generateBoundary();
  }

  public function setUrl(UrlInterface $url) {
    $this->url = $url;
  }
  
  public function getUrl() {
    return $this->url;
  }
  
  public function hasBody() {
    return $this->getBody() != '';
  }


  public function getBody() {
    return $this->body . $this->getParameters()->toString();
  }

  public function setBody($body) {
    $this->body = $body;
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

  public function setFiles(FileCollectionInterface $files) {
    $this->files = $files;
    $this->files->setBoundary($this->boundary);
  }

  public function getFiles() {
    return $this->files;
  }
  
  public function hasFiles() {
    return !\is_null($this->files);
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
  
  public function getPort() {
    
    if (!is_numeric($this->port)) {
      return $this->getUrl()->getPort();
    }
      
    return 80;
  }

  public function setPort($port) {
    $this->port = $port;
  }
  
  public function getVersion() {
    return $this->version;
  }

  public function setVersion($version) {
    $this->version = $version;
  }
    
  public function toString() {
    
    $data = "";
    if (!is_null($this->url)) {
      $data = \sprintf("%s %s HTTP/%s\r\n", $this->getMethod(), $this->url->getPathAndQuery(), $this->getVersion());
      $data .= \sprintf("Host: %s\r\n", $this->url->getHostname());
    }
    
    if ($this->hasHeaders()) {
      foreach ($this->getHeaders() as $header) {
        $data .= $header . "\r\n";
      }
    }
    
    $body = '';
    $length = 0;
    
    if ($this->hasFiles()) {
      $data .= "Content-type: multipart/form-data, boundary=$this->boundary\r\n";
    }
    else if ($this->hasBody()) {
      $data .= "Content-Type: application/x-www-form-urlencoded\r\n";
    }
    
    if($this->hasBody()) {  
      $body .= $this->getBody() . "\r\n";
      
      $length += strlen($body);      
    }
    
    if ($this->hasFiles()) {
      
      foreach ($this->getFiles() as $file) {

        $body .= "--$this->boundary\r\n";
        $body .= sprintf("Content-Disposition: form-data; name=\"%s\"; filename=\"%s\"\r\n", $file->getName(), $file->getValue());
        $body .= sprintf("Content-Type: %s\r\n\r\n", $file->getType());
        $content = $file->getContent();
        $body .= "". \base64_encode($content)."\r\n";
        
        $length += \strlen($content);
      }
    }
    
    $data .= "Content-Length: ". $length ."\r\n";
    
    if (\strlen($body)) {
      $data .= "\r\n". $body;
    }
    
    if ($this->hasFiles()) {
      $data .="--$this->boundary--";
    }
    
    $data .= "\r\n";
    
     
    return $data;
  }
  
  public function __toString() {
    return $this->toString();
  }
  
  protected function generateBoundary() {
    srand((double)microtime()*1000000);
    $this->boundary = "---------------------".substr(md5(rand(0,32000)),0,10);
  }
}