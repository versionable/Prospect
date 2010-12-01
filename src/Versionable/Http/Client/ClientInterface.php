<?php

namespace Versionable\Http\Client;

use Versionable\Http\Adapter\AdapterInterface;
use Versionable\Http\Request\RequestInterface;
use Versionable\Http\Response\ResponseInterface;

interface ClientInterface {
  public function setAdapter(AdapterInterface $adapter);

  public function getAdapter();

  public function send(RequestInterface $request, ResponseInterface $response);
}
