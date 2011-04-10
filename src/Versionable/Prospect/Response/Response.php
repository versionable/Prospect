<?php

namespace Versionable\Prospect\Response;

use Versionable\Prospect\Header\Collection as HeaderCollection;
use Versionable\Prospect\Cookie\Collection as CookieCollection;

use Versionable\Prospect\Header\CollectionInterface as HeaderCollectionInterface;
use Versionable\Prospect\Cookie\CollectionInterface as CookieCollectionInterface;

class Response implements ResponseInterface
{

  /*
   * @var integer HTTP Response code
   */
  protected $code = null;
  
  static public $valid_codes = array(
      100 => 'Continue',
      101 => 'Switching Protocols',
      200 => 'OK',
      201 => 'Created',
      202 => 'Accepted',
      203 => 'Non-Authoritative Information',
      204 => 'No Content',
      205 => 'Reset Content',
      206 => 'Partial Content',
      300 => 'Multiple Choices',
      301 => 'Moved Permanently',
      302 => 'Found',
      303 => 'See Other',
      304 => 'Not Modified',
      305 => 'Use Proxy',
      307 => 'Temporary Redirect',
      400 => 'Bad Request',
      401 => 'Unauthorized',
      402 => 'Payment Required',
      403 => 'Forbidden',
      404 => 'Not Found',
      405 => 'Method Not Allowed',
      406 => 'Not Acceptable',
      407 => 'Proxy Authentication Required',
      408 => 'Request Timeout',
      409 => 'Conflict',
      410 => 'Gone',
      411 => 'Length Required',
      412 => 'Precondition Failed',
      413 => 'Request Entity Too Large',
      414 => 'Request-URI Too Long',
      415 => 'Unsupported Media Type',
      416 => 'Requested Range Not Satisfiable',
      417 => 'Expectation Failed',
      418 => 'I\'m a teapot',
      500 => 'Internal Server Error',
      501 => 'Not Implemented',
      502 => 'Bad Gateway',
      503 => 'Service Unavailable',
      504 => 'Gateway Timeout',
      505 => 'HTTP Version Not Supported',
  );

  /**
   *
   * @var string Response body
   */
  protected $content = '';
  
  /**
   *
   * @var \Versionable\Prospect\Header\Collection
   */
  protected $headers = array();
  
  /**
   *
   * @var \Versionable\Prospect\Cookie\Collection
   */
  protected $cookies = array();
  
  public function parse($responseString)
  {    
    list($code, $headers, $cookies,  $content) = $this->parseResponse($responseString);
    
    $this->setCode($code);
    $this->setHeaders($headers);
    $this->setCookies($cookies);
    $this->setContent($content);
  }

  public function getCode()
  {
    return $this->code;
  }

  public function setCode($code)
  {
    if (array_key_exists($code, self::$valid_codes))
    {
      $this->code = $code;
    }
    else
    {    
      throw new \InvalidArgumentException('Unknown HTTP code: ' . $code);
    }
  }

  public function getContent()
  {
    return $this->content;
  }

  public function setContent($content)
  {
    $this->content = $content;
  }

  public function getHeaders()
  {
    return $this->headers;
  }

  public function setHeaders(HeaderCollectionInterface $headers)
  {
    $this->headers = $headers;
  }
  
  public function getCookies()
  {
    return $this->cookies;
  }

  public function setCookies(CookieCollectionInterface $cookies)
  {
    $this->cookies = $cookies;
  }
  
  protected function parseResponse($response)
  { 
    list($response_headers,$body) = explode("\r\n\r\n",$response,2); 

    $header_lines = explode("\r\n",$response_headers); 

    // first line of headers is the HTTP response code 
    $http_response_line = array_shift($header_lines); 
    
    $code = null;
    if (preg_match('@^HTTP/[0-9]\.[0-9] ([0-9]{3})@',$http_response_line, $matches))
    { 
      $code = $matches[1]; 
    }
    
    $cookies = new CookieCollection(); 
    $headers = new HeaderCollection(); 
    foreach($header_lines as $line)
    {
      list($name, $value) = explode(': ', $line);

      if ($name == 'Set-Cookie')
      {
        $cookies->parse($value);
      }
      else
      {
        $headers->parse($name, $value);
      }
    }

    return array($code, $headers, $cookies,  $body); 
  }
  
}