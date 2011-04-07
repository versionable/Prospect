<?php

namespace Versionable\Prospect\Client;

use Versionable\Prospect\Adapter\AdapterInterface;
use Versionable\Prospect\Request\RequestInterface;
use Versionable\Prospect\Response\ResponseInterface;
use Versionable\Prospect\UserAgent\UserAgentInterface;

class Client implements ClientInterface
{
  /**
   *
   * @var AdapterInterface Adapter used
   */
  protected $adapter = null;
  
  public function __construct(AdapterInterface $adapter = null)
  {
    if (!is_null($adapter))
    {
      $this->setAdapter($adapter);
    }
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