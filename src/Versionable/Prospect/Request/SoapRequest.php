<?php

namespace Versionable\Prospect\Request;

class SoapRequest extends Request
{
    protected $xmls;
    
    public function setXmls($xmls)
    {
        $this->xmls = $xmls;
    }
    
    public function getXmls()
    {
        return $this->xmls;
    }
}