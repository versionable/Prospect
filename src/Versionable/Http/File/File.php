<?php

namespace Versionable\Http\File;

class File implements FileInterface
{
  protected $type = '';

  protected $name = '';

  protected $value = '';

  public function __construct($name, $value, $type)
  {
    $this->setName($name);
    $this->setValue($value);
    $this->setType($type);
  }

  public function getName()
  {
    return $this->name;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function getValue()
  {
    return $this->value;
  }

  public function setValue($value)
  {
    $this->value = $value;
  }

  public function getContent()
  {
    return \file_get_contents($this->getValue());
  }

  public function __toString()
  {
    return $this->toString();
  }

  public function toString()
  {
    return $this->getContent();
  }

  public function getType()
  {
    return $this->type;
  }

  public function setType($type)
  {
    $this->type = $type;
  }
}
