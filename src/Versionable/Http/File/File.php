<?php

namespace Versionable\Http\File;

class File implements FileInterface
{
  protected $type = '';
  
  protected $name = '';
  
  protected $value = '';
  
  public function __construct($name, $value, $type) {
    $this->setName($name);
    $this->setValue($value);
    $this->setType($type);
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
  
  public function __toString() {
    return $this->toString();
  }
  
  public function toString() {
    srand((double)microtime()*1000000);
    $boundary = "---------------------".substr(md5(rand(0,32000)),0,10);
    $data .= "--$boundary\r\n";
    $content_file = join("", file($this->getValue()));
    $data .= sprintf("Content-Disposition: form-data; name=\"%s\"; filename=\"%s\"\r\n", $this->getName(), $this->getValue());
    $data .= sprintf("Content-Type: %s\r\n\r\n", $this->getType());
    $data .= "". \file_get_contents($this->getValue())."\r\n";
    $data .="--$boundary--\r\n";
    
    return $data;
  }

  public function getType() {
    return $this->type;
  }

  public function setType($type) {
    $this->type = $type;
  }
}
