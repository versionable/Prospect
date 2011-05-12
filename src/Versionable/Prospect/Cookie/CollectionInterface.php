<?php

namespace Versionable\Prospect\Cookie;

use Versionable\Common\Collection\MapInterface;

interface CollectionInterface extends MapInterface
{  
  public function toString();
  
  public function parse($string);
}
