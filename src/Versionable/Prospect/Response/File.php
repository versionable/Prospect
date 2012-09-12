<?php

namespace Versionable\Prospect\Response;

class File extends Response
{
  /**
   * @var string Filename
   */
  protected $filename = null;

  public function __construct()
  {
      $this->filename = \tempnam(\sys_get_temp_dir(), '');
  }

  public function getFilename()
  {
      return $this->filename;
  }

  public function setFilename($filename)
  {
      $this->filename = $filename;
  }
}
