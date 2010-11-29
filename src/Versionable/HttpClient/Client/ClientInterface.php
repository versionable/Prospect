<?php

namespace Versionable\HttpClient\Client;

use Versionable\HttpClient\Adapter\AdapterInterface;
use Versionable\HttpClient\Request\RequestInterface;
use Versionable\HttpClient\Response\ResponseInterface;

interface ClientInterface {
  public function setAdapter(AdapterInterface $adapter);

  public function getAdapter();

  public function send(RequestInterface $request, ResponseInterface $response);
}
