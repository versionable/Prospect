<?php

namespace Versionable\Http\Adapter;

use Versionable\Http\Request\RequestInterface;
use Versionable\Http\Response\ResponseInterface;

interface AdapterInterface {
  
  /*
   * @param Versionable\Http\RequestRequestInterface $request
   * @param Versionable\Http\Response\ResponseInterface $response
   * 
   * @return Versionable\Http\Response\ResponseInterface
   */
    public function call(RequestInterface $request, ResponseInterface $response);
}
