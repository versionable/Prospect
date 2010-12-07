<?php

namespace Versionable\Http\Header;

class ContentType extends Header
{
  protected $name = 'Content-Type';
  
  public function __construct($type) {
    $this->setValue($type);
  }
}
