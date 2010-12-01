<?php

namespace Versionable\Http\Response;

class Response implements ResponseInterface
{
  
  /*
   * @var integer HTTP Response code
   */
  protected $code = null;

  public function getCode() {
    return $this->code;
  }

  public function setCode($code) {
    $this->code = $code;
  }  
 
  public function getContent() {
    return $content;
  }

  public function setContent($content) {
    $this->content = $content;
  }

  public function getHeaders() {
    
  }

  public function setHeaders($headers) {
    
  }
}