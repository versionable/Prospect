<?php

namespace Versionable\Prospect\History;

use Versionable\Prospect\Request\RequestInterface;
use Versionable\Prospect\Response\ResponseInterface;

class Entry implements EntryInterface
{
  /**
   * @var Versionable\Prospect\Request\RequestInterface the request made
   */
  protected $request;
  
  /**
   * @var Versionable\Prospect\Response\ResponseInterface the response received
   */
  protected $response;
  
  public function __construct(RequestInterface $request, ResponseInterface $response)
  {
    $this->setRequest($request);
    $this->setResponse($response);
  }

  /**
   * Returns the request object
   * @return type Versionable\Prospect\Request\RequestInterface
   */
  public function getRequest()
  {
    return $this->request;
  }

  /**
   * Sets the request object
   * @param type $request Versionable\Prospect\Request\RequestInterface;
   */
  public function setRequest($request)
  {
    $this->request = $request;
  }

  /**
   * Returns the entries response object
   * @return type Versionable\Prospect\Response\ResponseInterface
   */
  public function getResponse()
  {
    return $this->response;
  }

  /**
   * Sets the response object
   * @param type $response Versionable\Prospect\Response\ResponseInterface
   */
  public function setResponse($response)
  {
    $this->response = $response;
  }
}