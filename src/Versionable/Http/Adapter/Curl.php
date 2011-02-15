<?php

namespace Versionable\Http\Adapter;

use Versionable\Http\Request\RequestInterface;
use Versionable\Http\Response\ResponseInterface;
use Versionable\Http\Parameter\FileIterface;

class Curl extends AdapterAbstract implements AdapterInterface
{
  /**
   *
   * @var resource Curl resource
   */
  protected $handle = null;

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
    if ($request->hasParameters())
    {
      foreach($request->getParameters() as $param)
      {
        $post[$param->getName()] = $param->getValue();
      }
    }

    if ($request->hasFiles())
    {
      foreach($request->getFiles() as $file)
      {
        $post[$file->getName()] = '@' . $file->getValue() . ';type=' . $file->getType();
      }
    }

    if ($request->getMethod() == 'POST' || $request->getMethod() == 'PUT')
    {
      \curl_setopt ($this->handle, \CURLOPT_POSTFIELDS, $post);
    }

    if ($request->hasCookies())
    {
      \curl_setopt($this->handle, \CURLOPT_COOKIE, $request->getCookies()->toString());
    }

    if ($request->hasHeaders())
    {
      \curl_setopt($this->handle, \CURLOPT_HEADER, 1);
      \curl_setopt($this->handle, \CURLOPT_HTTPHEADER, $request->getHeaders()->toArray());
    }
    else
    {
      \curl_setopt($this->handle, \CURLOPT_HEADER, 0);
    }

    \curl_setopt($this->handle, \CURLOPT_PORT, $request->getPort());

    $content = \curl_exec($this->handle);
    $info = \curl_getinfo($this->handle);

    $response->setCode($info['http_code']);
    $response->setContent($content);

    return $response;
  }
}
