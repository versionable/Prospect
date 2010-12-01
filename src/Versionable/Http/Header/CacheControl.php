<?php

namespace Versionable\Http\Header;

class CacheControl extends Header
{
  protected $name = 'Cache-Control';

  protected $value = '0';

  public function toString() {
    return sprintf('%s: max-age=%d', $this->name, $this->value);
  }
}
