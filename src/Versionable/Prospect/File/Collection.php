<?php

namespace Versionable\Prospect\File;

use Versionable\Common\Collection\Map;

class Collection extends Map implements CollectionInterface
{
  protected $boundary = '';
  
  public function add(FileInterface $file)
  {
    $this->put($file->getName(), $file);
  }

  public function toString()
  {
    $data = array();
    foreach($this->elements as $file)
    {
      $data[] = \sprintf('------------------------------%s', $this->boundary);
      $data[] = $file;
      $data[] = \sprintf('------------------------------%s', $this->boundary);
    }

    return implode("\r\n", $data);
  }

  public function setBoundary($boundary)
  {
    $this->boundary = $boundary;
  }
}
