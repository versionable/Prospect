<?php

namespace Versionable\Http\Url;

class Url implements UrlInterface {
  
  protected $scheme = 'http';
  
  protected $hostname = 'localhost';
  
  protected $port = 80;
  
  protected $username = null;
  
  protected $password = null;
  
  protected $path = '/';

  protected $parameters = array();  
  
  protected $fragment = '';
  
  protected $url = '';
  
  public function __construct($url, $parameters = array()) {
    $this->setParameters($parameters);
    $this->setUrl($url);
  }
  
  public function __toString() {
    return $this->toString();
  }
  
  public function toString() {
    return $this->getUrl();
  }

  public function getUrl() {
    return $this->url;
  }

  public function setUrl($url) {
    
    if (filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED) === false) {
      throw new \RuntimeException('Not a valid Url');
    }
    
    $components = parse_url($url);
    if (is_array($components))
    {      
      if (isset($components['user'])) {
        $this->setUsername($components['user']);
        if (isset($components['pass'])) {
          $this->setPassword($components['pass']);
        }
      }
    
      $this->setScheme($components['scheme']);
      
      if (\is_array($parameters)) {
        $this->setParameters(array_merge($this->parameters, parse_str($components['parameters'], $parameters)));
      }
      $this->setHostname($components['host']);
      $this->setPath($components['path']);
      $this->setPort($components['port']);
      $this->setScheme($components['scheme']);
      $this->setFragment($components['fragment']);
    }

    $this->url = $url;
  }
  
  public function setParameters(array $parameters) {
    $this->parameters = $parameters;
  }
  
  public function getParameters() {
    return $this->parameters;
  }


  public function getParameter($name) {
    if ($this->hasParameter($name)) {
      return $this->parameters[$name];
    }

    return null;
  }

  public function setParameter($name, $value) {
    $this->parameters[$name] = $value;
  }

  public function hasParameter($name) {
    return isset($this->parameters[$name]);
  }
  
  public function setHostname($hostname) {
    $this->hostname = $hostname;
  }

  public function getHostname() {
    return $this->hostname;
  }
  
  public function setScheme($scheme) {
    
    if ($this->getPort() == 80 || $this->getPort() == 443) {
      if ($this->getScheme() == 'http') {
        $this->setPort(80);
      } elseif ($this->getScheme() == 'https') {
        $this->setPort(443);
      }
    }
    
    $this->scheme = $scheme;
  }

  public function getScheme() {
    return $this->scheme;
  }
  
  public function setPort($port) {
    $this->port = (int)$port;
  }

  public function getPort() { 
    return $port;
  }
  
  public function setUsername($username) {
    $this->username = $username;
  }

  public function getUsername() {
    return $this->use;
  }
  
  public function setPassword($password) {
    $this->password = $password;
  }

  public function getPassword() {
    return \parse_url($this->url, \PHP_URL_PASS);
  }
  
  public function setPath($path) {
    
    if(empty($path)) {
      $path = '/';
    }
    
    $this->path = $path;
  }

  public function getPath() {
    return $this->path;
  }
  
  public function setFragment($fragment) {
    $this->fragment = $fragment;
  }

  public function getFragment() {
    return $this->fragment;
  }
  
  public function getPathAndQuery() {
    
    $path = $this->path;
    if (count($this->parameters) > 0) {
      $path .= "?" . http_build_query($this->getParameters());
    }
    
    return $path;
  }
}
