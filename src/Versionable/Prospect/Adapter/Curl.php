<?php

/*
 * This file is part of the Versionable Prospect package.
 *
 * (c) Stuart Lowes <stuart.lowes@versionable.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Versionable\Prospect\Adapter;

use Versionable\Prospect\Request\RequestInterface;
use Versionable\Prospect\Response\ResponseInterface;

class Curl extends AdapterAbstract implements AdapterInterface
{
  /**
   * The Curl handle or null
   * @var resource Curl resource
   */
  private $handle = null;

  public function __construct()
  {
    if (!extension_loaded('curl'))
    {
      throw new \RuntimeException('Curl extension not loaded');
    }
  }

  /**
   * Sends the request to the server
   * @param RequestInterface $request
   * @param ResponseInterface $response
   * @return ResponseInterface
   */
  public function call(RequestInterface $request, ResponseInterface $response)
  {
    $this->setOption(CURLOPT_URL, $request->getUrl());

    if ($request->getMethod() == 'GET')
    {
      $this->setOption(\CURLOPT_HTTPGET, true);
    }
    elseif ($request->getMethod() == 'POST')
    {
      $this->setOption(\CURLOPT_POST, true);
    }
    else
    {
      $this->setOption(\CURLOPT_CUSTOMREQUEST, $request->getMethod());
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

    if ($request->getMethod() == 'POST' || $request->getMethod() == 'PUT')
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

      $this->setOption(\CURLOPT_POSTFIELDS, $body);
    }

    if (!$request->getCookies()->isEmpty())
    {
      $this->setOption(\CURLOPT_COOKIE, $request->getCookies()->toString());
    }

    if (!$request->getHeaders()->isEmpty())
    {
      $this->setOption(\CURLOPT_HTTPHEADER, $request->getHeaders()->toArray());
    }

    $this->setOption(\CURLOPT_PORT, $request->getPort());

    $this->initialize();
    $returned = \curl_exec($this->getHandle());

    if (!$returned)
    {
      throw new \RuntimeException('Error connecting to host: ' . $request->getUrl()->getHostname());
    }

    $response->parse($returned);

    return $response;
  }

  public function getHandle() {
      return $this->handle;
  }

  public function setHandle($handle)
  {
      $this->handle = $handle;
  }

  protected function initialize()
  {
    $this->setHandle(\curl_init());
    $this->setOption(\CURLOPT_RETURNTRANSFER, true);
    $this->setOption(\CURLOPT_NOBODY, null);
    $this->setOption(\CURLOPT_FOLLOWLOCATION, true);
    $this->setOption(\CURLOPT_MAXREDIRS, 5);
    $this->setOption(\CURLOPT_HEADER, true);

    foreach($this->getOptions() as $name => $value)
    {
      $this->setOption($name, $value);
    }
  }
}
