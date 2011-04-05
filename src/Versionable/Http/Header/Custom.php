<?php
namespace Versionable\Http\Header;

class ContentType extends Header
{
  public function __construct($name = null, $value = null)
  {
    $this->setName($name);
    $this->setValue($value);
  }
}