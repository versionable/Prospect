<?php

namespace Versionable\Http\File;

interface FileInterface
{

  public function __construct($name, $value, $type);

  public function __toString();

  public function toString();

  public function getContent();

  public function getType();

  public function setType($type);
}
