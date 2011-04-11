<?php

namespace Versionable\Prospect\Header;

class Connection extends Header
{
  protected $name = 'Connection';

  protected $value = 'keep-alive';

  public function setValue($value)
  {
    $this->value = $value;
  }

}
