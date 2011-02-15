<?php

namespace Versionable\Http\Parameter;

interface CollectionInterface
{
  public function __toString();

  public function add(ParameterInterface $parameter);

  public function remove($name);

  public function get($name);

  public function has($name);

  public function toString();

  public function toArray();
}
