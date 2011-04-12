<?php

namespace Versionable\Prospect\Header;

class AcceptEncoding extends Header
{
  protected $name = 'Accept-Encoding';

  protected $value = 'gzip;q=1.0, identity; q=0.5, *;q=0';
}
