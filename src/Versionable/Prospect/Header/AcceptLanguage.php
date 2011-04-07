<?php

namespace Versionable\Prospect\Header;

class Accept extends Header
{
  protected $name = 'Cache-Control';

  protected $value = 'max-age=0';
}
