<?php

namespace Versionable\HttpClient\Adapter;

use Versionable\HttpClient\Request\RequestInterface;
use Versionable\HttpClient\Response\ResponseInterface;

class Stream implements AdapterInterface
{

  protected $options = array(
      'returntransfer' => array('name' => \CURLOPT_RETURNTRANSFER, 'value' => true),
      //'nobody' => array('name' => \CURLOPT_NOBODY, 'value' => null)
  );

  public function __construct() {
    if (!extension_loaded('curl'))
    {
      throw new \RuntimeException('Curl extension not loaded');
    }
  }

  public function initalize()
  {
  }

  public function call(RequestInterface $request, ResponseInterface $response)
  {
    $this->initalize();

    if ($request->getMethod() == 'GET') {
      
    } elseif ($request->getMethod() == 'POST') {
      
    } elseif ($request->getMethod() == 'PUT') {
      
    } else {
      
    }
    
    $transport = parse_url($url, PHP_URL_SCHEME) == 'https' ? 'ssl' : 'http';
    
    $opts = array();
    
    $opts[$transport] = array();
    $opts[$transport]['method'] = $this->getMethod();
    $opts[$transport]['header'] = $request->getHeaders()->toArray();
    $opts[$transport]['content'] = $request->getContent();

    $response->setCode($info['http_code']);
    $response->setContent($content);

    return $response;
  }

  public function setOption($name, $value) {

    if (isset($this->options[$name])) {
      $this->options[$name]['value'] = $value;

      return true;
    }

    return false;
  }
}
