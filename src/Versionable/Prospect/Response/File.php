<?php

namespace Versionable\Prospect\Response;

class File extends Response
{
  /**
   * @var string Filename
   */
  protected $filename;

  public function __construct()
  {
      $this->filename = sys_get_temp_dir().DIRECTORY_SEPARATOR.uniqid('prospect_', true);
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
