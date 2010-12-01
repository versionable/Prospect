<?php

namespace Versionable\Http\Header;

interface CollectionInterface {
  public function add(HeaderInterface $header);
  
  public function remove($name);

  public function get($name);
  
  public function has($name);
  
  public function toArray();
}
