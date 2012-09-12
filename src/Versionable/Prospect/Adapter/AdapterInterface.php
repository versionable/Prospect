<?php

namespace Versionable\Prospect\Adapter;

use Versionable\Prospect\Request\RequestInterface;
use Versionable\Prospect\Response\ResponseInterface;

interface AdapterInterface
{
  /*
   * @param Versionable\Prospect\RequestRequestInterface $request
   * @param Versionable\Prospect\Response\ResponseInterface $response
   *
   * @return Versionable\Prospect\Response\ResponseInterface
   */
    public function call(RequestInterface $request, ResponseInterface $response);

    public function setOption($name, $value);
}
