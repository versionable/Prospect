<?php

namespace Versionable\HttpClient\File;

interface FileInterface {
  public function getFilename();

  public function setFilename($filename);

  public function getType();

  public function setType($type);
}
