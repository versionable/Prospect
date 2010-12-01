<?php

namespace Versionable\Http\Parameter;

interface FileInterface {
  
  public function __construct($name, $value, $type);
  
  public function getType();

  public function setType($type);
}
