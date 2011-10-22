<?php

namespace Versionable\Prospect\Header;

use Versionable\Common\Collection\Map;

class Collection extends Map implements CollectionInterface
{
  public function add(HeaderInterface $header)
  {
    $this->put($header->getName(), $header);
  }
  
  public function parse($name, $value)
  {
    $class_name = 'Versionable\Prospect\Header\\' . \str_replace(' ' , '', \ucwords(\str_replace('-', ' ', $name)));

    if (class_exists($class_name)) {
        $header = new $class_name($value);
    } else {
        $header = new Custom($name, $value);
    }
    
    $this->add($header);
  }
  
  public function toString()
  {
    $data = '';
    foreach ($this as $header)
    {
      $data .= $header->toString() . "\r\n";
    }

    return $data; 
  }
}
