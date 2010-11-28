<?php

namespace Versionable\HttpClient\Adapter;

use Versionable\HttpClient\Request\RequestInterface;
use Versionable\HttpClient\Response\ResponseInterface;

interface AdapterInterface {
  
  /*
   * @param Versionable\HttpClient\RequestRequestInterface $request
   * @param Versionable\HttpClient\Response\ResponseInterface $response
   * 
   * @return Versionable\HttpClient\Response\ResponseInterface
   */
  public function call(RequestInterface $request, ResponseInterface $response);
}
