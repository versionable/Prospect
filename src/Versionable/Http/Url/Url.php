<?php

namespace Versionable\Http\Url;

class Url implements UrlInterface {
  protected $url = '';
  
  protected $parameters = array();
  
  public function __construct($url, $parameters = array()) {
    $this->setUrl($url);
    $this->setParameters($parameters);
  }
  
  public function __toString() {
    return $this->toString();
  }
  
  public function toString() {
    $url = $this->url;
    if (count($this->parameters) > 0) {
      $url = $url . '?' . http_build_query($this->parameters);
    }
    
    return $url;
  }

  public function getUrl() {
    return $this->url;
  }

  public function setUrl($url) {
    
    $components = parse_url($url);
    if (is_array($components))
    {
      parse_str($components['query'], $query);

      $this->parameters = array_merge($this->parameters, $query);
    }
    
    $this->url = $components['scheme'] . '://' . $components['host'] . $components['path'];
  }

  public function getParameters() {
    return $this->parameters;
  }

  public function setParameters(array $parameters) {
    $this->parameters = $parameters;
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
}
