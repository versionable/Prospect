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

  public function __toString()
  {
    return sprintf('%s: %d', $this->name, $this->value);
  }
}
