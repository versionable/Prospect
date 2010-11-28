<?php

namespace Versionable\HttpClient;

use Versionable\HttpClient\Adapter\AdapterInterface;
use Versionable\HttpClient\Request\RequestInterface;
use Versionable\HttpClient\Response\ResponseInterface;
use Versionable\HttpClient\UserAgent\UserAgentInterface;

class Client implements ClientInterface
{
  protected $adapter = null;

  protected $agent = null;

  public function setUserAgent(UserAgentInterface $useragent) {
    $this->agent = $useragent;
  }

  public function getUserAgent() {
    return $this->agent;
  }


  public function setAdapter(AdapterInterface $adapter) {
    $this->adapter = $adapter;
  }

  public function getAdapter() {
    return $this->adapter;
  }

  public function send(RequestInterface $request, ResponseInterface $response)
  {    
    $response = $this->adapter->call($request, $response);

    return $response;
  }
}