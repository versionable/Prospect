<?php

namespace Versionable\Prospect\Adapter;

use Versionable\Prospect\Request\RequestInterface;
use Versionable\Prospect\Response\ResponseInterface;

class Curl extends AdapterAbstract implements AdapterInterface
{
  /**
   *
   * @var resource Curl resource
   */
  protected $handle = null;
  
  /**
   *
   * @var array Curl options 
   */
  protected $options = array();

  public function __construct()
  {
    if (!extension_loaded('curl'))
    {
      throw new \RuntimeException('Curl extension not loaded');
    }
  }

  public function initialize()
  {    
    $this->handle = curl_init();
    $this->setOption(\CURLOPT_RETURNTRANSFER, true);
    $this->setOption(\CURLOPT_NOBODY, null);
    $this->setOption(\CURLOPT_FOLLOWLOCATION, true);
    $this->setOption(\CURLOPT_MAXREDIRS, 5);
    $this->setOption(\CURLOPT_HEADER, true);
    
    foreach($this->options as $name => $value)
    {
      \curl_setopt($this->handle, $name, $value);
    }
  }

  public function call(RequestInterface $request, ResponseInterface $response)
  {
    $this->initialize();
   
    \curl_setopt($this->handle, CURLOPT_URL, $request->getUrl());

    if ($request->getMethod() == 'GET')
    {
      \curl_setopt($this->handle, \CURLOPT_HTTPGET, true);
    }
    elseif ($request->getMethod() == 'POST')
    {
      \curl_setopt($this->handle, \CURLOPT_POST, true);
    }
    else
    {
      \curl_setopt($this->handle, \CURLOPT_CUSTOMREQUEST, $request->getMethod());
    }

    $post = array();
    $files = array();
    
    foreach($request->getParameters() as $param)
    {
      $post[$param->getName()] = $param->getValue();
    }

    foreach($request->getFiles() as $file)
    {
      $files[$file->getName()] = '@' . $file->getValue() . ';type=' . $file->getType();
    }

    if ($request->getMethod() == 'POST' ||
        $request->getMethod() == 'PUT'  ||
        $request->getMethod() == 'PATCH')
    { 
      // Files and any parameters - note body is not used
      if (!empty($files))
      {
        $body = array_merge($post, $files);
      }
      
      // Only parametsrs
      elseif (!empty($post))
      {
        $body = http_build_query($post);
      }
      
      else
      {
        $body = $request->getBody();
      }
      
      \curl_setopt ($this->handle, \CURLOPT_POSTFIELDS, $body);
    }

    if (!$request->getCookies()->isEmpty())
    {
      \curl_setopt($this->handle, \CURLOPT_COOKIE, $request->getCookies()->toString());
    }

    if (!$request->getHeaders()->isEmpty())
    {
      \curl_setopt($this->handle, \CURLOPT_HTTPHEADER, $request->getHeaders()->toArray());
    }

    \curl_setopt($this->handle, \CURLOPT_PORT, $request->getPort());
    
    $returned = \curl_exec($this->handle);
    
    if (!$returned)
    {
      throw new \RuntimeException('Error connecting to host: ' . $request->getUrl()->getHostname());
    }
    
    $response->parse($returned);
    
    return $response;
  }
}