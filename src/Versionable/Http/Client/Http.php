<?php

namespace Versionable\Http\Client;

use Versionable\Http\Adapter\AdapterInterface;
use Versionable\Http\Request\RequestInterface;
use Versionable\Http\Response\ResponseInterface;
use Versionable\Http\UserAgent\UserAgentInterface;

class Http implements HttpInterface
{
  /**
   *
   * @var AdapterInterface Adapter used
   */
  protected $adapter = null;
  
  public function __construct(AdapterInterface $adapter = null)
  {
    $this->setAdapter($adapter);
  }

  public function setAdapter(AdapterInterface $adapter)
  {
    $this->adapter = $adapter;
  }

  public function getAdapter()
  {
    return $this->adapter;
  }

  public function send(RequestInterface $request, ResponseInterface $response)
  {
    $response = $this->adapter->call($request, $response);

    return $response;
  }
}