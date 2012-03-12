<?php

namespace Versionable\Prospect\Url;

class SoapUrl extends Url
{
    protected $xmls;

    public function setUrl($url)
    {
        $this->setPath($url);
    }
    
    public function getUrl()
    {
        return $this->getPath();
    }
}