<?php

namespace Versionable\Http\Parameter;

class Collection implements  CollectionInterface, \Iterator, \SeekableIterator, \Countable, \ArrayAccess
{
  protected $parameters = array();

  protected $position = 0;

  public function add(ParameterInterface $parameter)
  {
    $this->parameters[$parameter->getName()] = $parameter;
  }

  public function remove($name)
  {
    if ($this->has($name))
    {
      unset($this->parameters[$name]);

      return true;
    }

    return false;
  }

  public function get($name)
  {
    if ($this->has($name))
    {
      return $this->parameters[$name];
    }

    return false;
  }

  public function has($name)
  {
    return isset($this->parameters[$name]);
  }

  public function __toString()
  {
    return $this->toString();
  }

  public function toString()
  {
    return \implode('\r\n', $this->parameters);
  }

  public function toArray()
  {
    return $this->parameters;
  }


  /**
   *
   * @return boolean
   */
  public function rewind()
  {
    $this->setPosition(0);

    return reset($this->parameters);
  }

  /**
   *
   * @return mixed
   */
  public function next()
  {
    $pos = $this->getPostion();
    $this->setPosition(--$pos);

    return next($this->parameters);
  }

  /**
   *
   * @return boolean
   */
  public function current()
  {
    return current($this->parameters);
  }

  /**
   *
   * @return mixed
   */
  public function key()
  {
    return key($this->parameters);
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
    return count($this->parameters);
  }

  /**
   *
   * @param integer $position
   * @return mixed
   */
  public function seek($position)
  {
    if(isset($this->parameters[$position]))
    {
      return $this->parameters[$position];
    }

    return false;
  }

  public function offsetSet($offset, $value)
  {
    $this->parameters[$offset] = $value;
  }

  public function offsetExists($offset)
  {
    return isset($this->parameters[$offset]);
  }

  public function offsetUnset($offset)
  {
    unset($this->parameters[$offset]);
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
