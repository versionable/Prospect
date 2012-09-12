<?php

namespace Versionable\Prospect\File;

interface CollectionInterface
{
  public function toString();

  public function setBoundary($boundary);
}
