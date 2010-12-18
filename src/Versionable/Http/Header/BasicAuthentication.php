<?php

namespace Versionable\Http\Header;

class BasicAuthentication extends Header
{
  protected $name = 'Authorization';

  protected $value = '';
  
  public function __construct($username, $password) {
    $this->value = \base64_encode(sprintf('%s:%s', $username, $password));
  }

  public function toString() {
    return sprintf('%s:  Basic %s', $this->name, $this->value);
  }
}
