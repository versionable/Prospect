<?php

namespace Versionable\Http\Adapter;

abstract class AdapterAbstract
{
  protected $options = array();
  
  public function setOption($name, $value) {
    $this->options[$name]['value'] = $value;
  }
}
