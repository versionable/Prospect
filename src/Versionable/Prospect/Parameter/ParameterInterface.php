<?php

namespace Versionable\Prospect\Parameter;

interface ParameterInterface
{
  public function __toString();

  public function toString();

  public function getName();

  public function setName($name);

  public function getValue();

  public function setValue($value);
}
