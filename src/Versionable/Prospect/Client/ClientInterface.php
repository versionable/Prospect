<?php

namespace Versionable\Prospect\Client;

use Versionable\Prospect\Adapter\AdapterInterface;
use Versionable\Prospect\Request\RequestInterface;
use Versionable\Prospect\Response\ResponseInterface;

interface ClientInterface
{
  public function setAdapter(AdapterInterface $adapter);

  public function getAdapter();

  public function send(RequestInterface $request, ResponseInterface $response);
}
