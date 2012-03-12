<?php

namespace Versionable\Prospect\Adapter;

use Versionable\Prospect\Adapter\AdapterAbstract;
use Versionable\Prospect\Request\RequestInterface;
use Versionable\Prospect\Response\ResponseInterface;

class Soap extends AdapterAbstract implements AdapterInterface
{
    var $handle;
    
    public function __construct($wdsl, array $opts = array())
    {
        if (!extension_loaded('soap')) {
          throw new \RuntimeException('Soap extension not loaded');
        }
        
        $this->setOption('WDSL', $wdsl);
        $this->setOption('SOAP_OPTS', $opts);
    }
    
    public function initialize()
    {
        if(null === $this->handle) {
            if(!empty($this->options['WDSL'])) {
                $this->handle = new \SOAPClient($this->options['WDSL'], $this->options['SOAP_OPTS']);
            } else {
                throw new \RuntimeException('WDSL not specified');
            }
        }
    }

    public function call(RequestInterface $request, ResponseInterface $response)
    {
        $this->initialize();

        $headers = $request->getUrl()->getParameters();

        $soapHeaders = array();

        foreach ($headers as $name => $key) {
            $soapHeaders[] = new \SoapHeader($request->getXmls(), $name, $key);
        }

        $parameters = $request->getParameters()->toArray();

        $soapParameters = array();

        foreach($parameters as $parameter)
        {
            $soapParameters[$parameter->getName()] = $parameter->getValue();
        }

        return $this->handle->__soapCall($request->getUrl(), $soapParameters, null, $soapHeaders, $outputHeaders);
    }
}