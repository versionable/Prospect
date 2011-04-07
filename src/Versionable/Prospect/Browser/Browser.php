<?php

namespace Versionable\Prospect\Browser;

use Versionable\Prospect\Client\ClientInterface;
use Versionable\Prospect\History\HistoryInterface;
use \Versionable\Prospect\Request\RequestInterface;
use \Versionable\Prospect\Response\ResponseInterface;

class Browser implements BrowserInterface
{
  protected $client = null;
  
  protected $history = null;
  
  public function __construct(ClientInterface $client, HistoryInterface $history)
  {
    $this->setClient($client);
    $this->setHistory($history);
  }
  
  public function get(RequestInterface $request, ResponseInterface $response)
  {
    return $this->getClient()->send($request, $response);
  }
  
  public function getClient()
  {
    return $this->client;
  }

  public function setClient(ClientInterface $client)
  {
    $this->client = $client;
  }

  public function getHistory()
  {
    return $this->history;
  }

  public function setHistory(HistoryInterface $history)
  {
    $this->history = $history;
  }
}
