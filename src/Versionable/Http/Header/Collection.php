<?php

namespace Versionable\Http\Header;

class Collection implements CollectionInterface, \Iterator, \SeekableIterator, \Countable, \ArrayAccess
{
  /**
   *
   * @var array Array of \Versionable\Http\Header\HeaderInterface
   */
  protected $headers = array();

  /**
   *
   * @var integer Position of pointer 
   */
  protected $position = 0;

  public function add(HeaderInterface $header)
  {
    $this->headers[$header->getName()] = $header;
  }

  public function remove($name)
  {
    if ($this->has($name))
    {
      unset($this->headers[$name]);

      return true;
    }

    return false;
  }

  public function get($name)
  {
    if ($this->has($name))
    {
      return $this->headers[$name];
    }

    return false;
  }

  public function has($name)
  {
    return isset($this->headers[$name]);
  }

  public function toArray()
  {
    $headers = array();
    
    foreach($this->header as $header)
    {
      $headers[] = $header->toString();
    }
    
    return $headers;
  }


  /**
   *
   * @return boolean
   */
  public function rewind()
  {
    $this->setPosition(0);

    return reset($this->headers);
  }

  /**
   *
   * @return mixed
   */
  public function next()
  {
    $pos = $this->getPostion();
    $this->setPosition(--$pos);

    return next($this->headers);
  }

  /**
   *
   * @return boolean
   */
  public function current()
  {
    return current($this->headers);
  }

  /**
   *
   * @return mixed
   */
  public function key()
  {
    return key($this->headers);
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
    return count($this->headers);
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
  
  public function parse($name, $value)
  {
    $class_name = '\Versionable\Http\Header\\' . \str_replace('-', '', $name);
    if (\class_exists($class_name))
    {
      $header = new $class_name($value);
    }
    else
    {
      $header = new Header($class_name, $value);
    }
    
    $this->add($header);
  }
}
