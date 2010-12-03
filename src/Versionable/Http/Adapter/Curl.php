<?php

namespace Versionable\Http\Adapter;

use Versionable\Http\Request\RequestInterface;
use Versionable\Http\Response\ResponseInterface;
use Versionable\Http\Parameter\FileIterface;

class Curl implements AdapterInterface
{

  protected $ch = null;

  protected $options = array(
      'returntransfer' => array('name' => \CURLOPT_RETURNTRANSFER, 'value' => true),
      'nobody' => array('name' => \CURLOPT_NOBODY, 'value' => null)
  );

  public function __construct() {
    if (!extension_loaded('curl'))
    {
      throw new \RuntimeException('Curl extension not loaded');
    }
  }

  public function initialize()
  {
    $this->ch = curl_init();

    foreach($this->options as $option) {
      \curl_setopt($this->ch, $option['name'], $option['value']);
    }
    \curl_setopt($this->ch, \CURLOPT_RETURNTRANSFER, true); 
  }

  public function setOption($name, $value) {

    if (isset($this->options[$name])) {
      $this->options[$name]['value'] = $value;

      return true;
    }

    return false;
  }

  public function call(RequestInterface $request, ResponseInterface $response)
  {
    $this->initialize();

    \curl_setopt($this->ch, CURLOPT_URL, $request->getUrl()->toString());

    if ($request->getMethod() == 'GET') {
      \curl_setopt($this->ch, \CURLOPT_HTTPGET, true);
    } elseif ($request->getMethod() == 'POST') {
      \curl_setopt($this->ch, \CURLOPT_POST, true);
    } else {
      \curl_setopt($this->ch, \CURLOPT_CUSTOMREQUEST, $request->getMethod());
    }

    $post = array();
    foreach($request->getParameters() as $param) {
      $class = new \ReflectionClass(\get_class($param));
      if ($class->implementsInterface('Versionable\\Http\\Parameter\\FileInterface')) {
        $post[$param->getName()] = '@' . $param->getValue() . ';type=' . $param->getType();
      } else {
        $post[$param->getName()] = $param->getValue();
      }
    }
    
    if ($request->getMethod() == 'POST' || $request->getMethod() == 'PUT') {
      \curl_setopt ($this->ch, \CURLOPT_POSTFIELDS, $post);
    }

    if ($request->hasCookies()) {
      \curl_setopt($this->ch, \CURLOPT_COOKIE, $request->getCookies()->toString());
    }

    if ($request->getHeaders()) {
      \curl_setopt($this->ch, \CURLOPT_HEADER, 1);
      \curl_setopt($this->ch, \CURLOPT_HTTPHEADER, $request->getHeaders()->toArray());
    } else {
      \curl_setopt($this->ch, \CURLOPT_HEADER, 0);
    }

    $content = \curl_exec($this->ch);
    $info = \curl_getinfo($this->ch);

    $response->setCode($info['http_code']);
    $response->setContent($content);

    return $response;
  }
}
