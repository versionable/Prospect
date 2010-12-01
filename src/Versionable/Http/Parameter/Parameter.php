<?php

namespace Versionable\Http\Parameter;

class Parameter implements ParameterInterface
{
  protected $name;
  
  protected $value;
  
  public function __construct($name, $value) {
    $this->setName($name);
    $this->setValue($value);
  }

  public function getName() {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function getValue() {
    return $this->value;
  }

  public function setValue($value) {
    $this->value = $value;
  }
}
