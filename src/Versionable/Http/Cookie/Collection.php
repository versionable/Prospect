<?php

namespace Versionable\Http\Cookie;

class Collection implements CollectionInterface, \Iterator, \SeekableIterator, \Countable, \ArrayAccess {
  
  protected $cookies = array();
  
  protected $position = 0;

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
  

  /**
   *
   * @return boolean
   */
  public function rewind()
  {
    $this->setPosition(0);

    return reset($this->cookies);
  }

  /**
   *
   * @return mixed
   */
  public function next()
  {
    $pos = $this->getPostion();
    $this->setPosition(--$pos);

    return next($this->cookies);
  }

  /**
   *
   * @return boolean
   */
  public function current()
  {
    return current($this->cookies);
  }

  /**
   *
   * @return mixed
   */
  public function key()
  {
    return key($this->cookies);
  }

  /**
   *
   * @return boolean
   */
  public function valid()
  {
    return $this->current() !== false;
  }

  /**
   *
   * @return integer
   */
  public function count()
  {
    return count($this->cookies);
  }

  /**
   *
   * @param integer $position
   * @return mixed
   */
  public function seek($position)
  {
    if(isset($this->cookies[$position]))
    {
      return $this->cookies[$position];
    }

    return false;
  }

  public function offsetSet($offset, $value)
  {
    $this->cookies[$offset] = $value;
  }

  public function offsetExists($offset)
  {
    return isset($this->cookies[$offset]);
  }

  public function offsetUnset($offset)
  {
    unset($this->cookies[$offset]);
  }

  public function offsetGet($offset)
  {
    return $this->seek($offset);
  }

  /**
   *
   * @param integer $position
   */
  protected function setPosition($position)
  {
    $this->position = (int)$position;
  }

  /**
   *
   * @return integer
   */
  protected function getPostion()
  {
    return $this->position;
  }
}
