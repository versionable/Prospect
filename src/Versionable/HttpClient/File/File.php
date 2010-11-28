<?php

namespace Versionable\HttpClient\File;

class File implements FileInterface
{
  protected $filename = '';

  protected $type = '';
  
  public function __construct($filename, $type) {
    $this->setFilename($filename);
    $this->setType($type);
  }

  public function getFilename() {
    return $this->filename;
  }

  public function setFilename($filename) {
    $this->filename = $filename;
  }

  public function getType() {
    return $this->type;
  }

  public function setType($type) {
    $this->type = $type;
  }
}
