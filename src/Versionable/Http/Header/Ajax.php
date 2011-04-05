<?php

namespace Versionable\Http\Header;

class Ajax extends Header
{
  protected $name = 'X-Requested-With';

  protected $value = 'XMLHttpRequest';
}
