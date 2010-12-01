<?php

namespace Versionable\Http\Parameter;

interface ParameterInterface {
  public function getName();

  public function setName($name);

  public function getValue();

  public function setValue($value);
}
