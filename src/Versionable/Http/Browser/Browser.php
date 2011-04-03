<?php

namespace Versionable\Http\Browser;

use Versionable\Http\Client\HttpInterface;
use Versionable\Http\History\HistoryInterface;
use \Versionable\Http\Request\RequestInterface;
use \Versionable\Http\Response\ResponseInterface;

class Browser implements BrowserInterface
{
  protected $client = null;
  
  protected $history = null;
  
  public function __construct(HttpInterface $client, HistoryInterface $history)
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

  public function setClient(HttpInterface $client)
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
