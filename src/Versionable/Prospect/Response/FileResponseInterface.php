<?php

namespace Versionable\Prospect\Response;

use Versionable\Prospect\Header\CollectionInterface as HeaderCollectionInterface;
use Versionable\Prospect\Cookie\CollectionInterface as CookieCollectionInterface;

interface FileResponseInterface
{   
    public function setFilename($filename);
    
    public function getFilename();
}