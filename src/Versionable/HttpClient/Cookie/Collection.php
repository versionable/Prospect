<?php

namespace Versionable\HttpClient\Cookie;

class Collection implements CollectionInterface, \Countable, \ArrayAccess {
  
  protected $cookies = array();

  public function add(CookieInterface $cookie) {
    $this->cookies[$cookie->getName()] = $cookie;
  }

  public function remove($name) {
    if ($this->has($name)) {
      unset($this->cookies[$name]);

      return true;
    }

    return false;
  }

  public function get($name) {
    if ($this->has($name)) {
      return $this->cookies[$name];
    }

    return false;
  }

  public function has($name) {
    return isset($this->cookies[$name]);
  }

  public function count() {
    return count($this->cookies);
  }

  public function __toString() {
    return $this->toString();
  }
  
  public function toString() {
    $cookies = array();

    foreach($this->cookies as $c) {
      $cookies[] = $c;
    }

    return implode(';', $cookies);
  }
  
  public function toArray() {
    return $this->cookies;
  }

  public function load() {

  }
  
  public function seek($position)
  {
    if(isset($this->headers[$position]))
    {
      return $this->headers[$position];
    }

    return false;
  }

  public function offsetSet($offset, $value)
  {
    $this->headers[$offset] = $value;
  }

  public function offsetExists($offset)
  {
    return isset($this->headers[$offset]);
  }

  public function offsetUnset($offset)
  {
    unset($this->headers[$offset]);
  }

  public function offsetGet($offset)
  {
    return $this->seek($offset);
  }
  
}
