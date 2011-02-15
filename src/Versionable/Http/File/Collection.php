<?php

namespace Versionable\Http\File;

class Collection implements  CollectionInterface, \Iterator, \SeekableIterator, \Countable, \ArrayAccess
{

  protected $files = array();

  protected $position = 0;

  protected $boundary = '';

  public function add(FileInterface $file)
  {
    $this->files[$file->getName()] = $file;
  }

  public function remove($name)
  {
    if ($this->has($name))
    {
      unset($this->files[$name]);

      return true;
    }

    return false;
  }

  public function get($name)
  {
    if ($this->has($name))
    {
      return $this->files[$name];
    }

    return false;
  }

  public function has($name)
  {
    return isset($this->files[$name]);
  }

  public function __toString()
  {
    return $this->toString();
  }

  public function toString()
  {
    $data = array();
    foreach($this->files as $file)
    {
      $data[] = \sprintf('------------------------------%s', $this->boundary);
      $data[] = $file;
      $data[] = \sprintf('------------------------------%s', $this->boundary);
    }

    return implode("\r\n", $data);
  }

  public function toArray()
  {
    return $this->files;
  }

  public function setBoundary($boundary)
  {
    $this->boundary = $boundary;
  }

  /**
   *
   * @return boolean
   */
  public function rewind()
  {
    $this->setPosition(0);

    return reset($this->files);
  }

  /**
   *
   * @return mixed
   */
  public function next()
  {
    $pos = $this->getPostion();
    $this->setPosition(--$pos);

    return next($this->files);
  }

  /**
   *
   * @return boolean
   */
  public function current()
  {
    return current($this->files);
  }

  /**
   *
   * @return mixed
   */
  public function key()
  {
    return key($this->files);
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
    return count($this->files);
  }

  /**
   *
   * @param integer $position
   * @return mixed
   */
  public function seek($position)
  {
    if(isset($this->files[$position]))
    {
      return $this->files[$position];
    }

    return false;
  }

  public function offsetSet($offset, $value)
  {
    $this->files[$offset] = $value;
  }

  public function offsetExists($offset)
  {
    return isset($this->files[$offset]);
  }

  public function offsetUnset($offset)
  {
    unset($this->files[$offset]);
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
