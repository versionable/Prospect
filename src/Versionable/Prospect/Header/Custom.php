<?php
namespace Versionable\Prospect\Header;

class Custom extends Header
{
  public function __construct($name = null, $value = null)
  {
    $this->setName($name);
    $this->setValue($value);
  }
}
