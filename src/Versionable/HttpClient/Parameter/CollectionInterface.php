<?php

namespace Versionable\HttpClient\Parameter;

interface CollectionInterface {
  public function add(ParameterInterface $parameter);

  public function remove($name);

  public function get($name);

  public function has($name);

  public function toString();
  
  public function toArray();
}
