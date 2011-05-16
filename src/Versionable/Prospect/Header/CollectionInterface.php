<?php

namespace Versionable\Prospect\Header;

interface CollectionInterface
{
  public function toString();
  
  public function add(HeaderInterface $header);
}
