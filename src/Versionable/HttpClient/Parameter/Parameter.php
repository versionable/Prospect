<?php

namespace Versionable\HttpClient\Parameter;

class Parameter
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
