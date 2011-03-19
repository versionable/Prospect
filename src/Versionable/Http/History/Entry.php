<?php

namespace Versionable\Http\History;

use Versionable\Http\Request\RequestInterface;
use Versionable\Http\Response\ResponseInterface;

class Entry implements EntryInterface
{
  /**
   * @var Versionable\Http\Request\RequestInterface the request made
   */
  protected $request;
  
  /**
   * @var Versionable\Http\Response\ResponseInterface the response received
   */
  protected $response;
  
  public function __construct(RequestInterface $request, ResponseInterface $response)
  {
    $this->setRequest($request);
    $this->setResponse($response);
  }

  /**
   * Returns the request object
   * @return type Versionable\Http\Request\RequestInterface
   */
  public function getRequest()
  {
    return $this->request;
  }

  /**
   * Sets the request object
   * @param type $request Versionable\Http\Request\RequestInterface;
   */
  public function setRequest($request)
  {
    $this->request = $request;
  }

  /**
   * Returns the entries response object
   * @return type Versionable\Http\Response\ResponseInterface
   */
  public function getResponse()
  {
    return $this->response;
  }

  /**
   * Sets the response object
   * @param type $response Versionable\Http\Response\ResponseInterface
   */
  public function setResponse($response)
  {
    $this->response = $response;
  }
}