<?php

namespace Versionable\Prospect\Header;

class Ajax extends Header
{
  protected $name = 'X-Requested-With';

  protected $value = 'XMLHttpRequest';
}
