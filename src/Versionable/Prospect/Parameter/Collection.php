<?php

namespace Versionable\Prospect\Parameter;

use Versionable\Common\Collection\Map;

class Collection extends Map implements CollectionInterface
{
  public function add(ParameterInterface $parameter)
  {
    $this->put($parameter->getName(), $parameter);
  }

  public function __toString()
  {
    return $this->toString();
  }

  public function toString()
  {
    $parameters = array();
    
    foreach($this->elements as $parameter)
    {
       $parameters[$parameter->getName()] = $parameter->getValue();
    }
    
    return http_build_query($parameters);
  }
  
  public function isValid($element)
  {
    if ($element instanceof ParameterInterface)
    {
      return true;
    }
    
    return false;
  }
}
