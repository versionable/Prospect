<?php

namespace Versionable\Prospect\Request;

use Versionable\Prospect\Header\Custom;
use Versionable\Prospect\Header\ContentType;

class StringBuilder
{
  protected $request = null;

  protected $head = '';

  protected $body = "";

  protected $contentLength = 0;

  protected $boundary ='';

  public function setRequest(RequestInterface $request)
  {
    $this->request = $request;
  }

  public function setBoundary($boundary)
  {
    $this->boundary = $boundary;
  }

  public function getBoundary()
  {
    return $this->boundary;
  }

  public function toString()
  {
    $this->data = '';
    $this->body = "\r\n";

    if (null === $this->getRequest() || null === $this->getRequest()->getUrl()) {
      throw new \RuntimeException('No getUrl() set for request');
    }

    if ($this->getBoundary() === '') {

      $this->generateBoundary();
    }

    $this->getHTTPHeader();

    $this->addToBody($this->getParameterString());

    if ($this->getRequest()->isMultipart()) {
      $this->getRequest()->getHeaders()->add(new ContentType('multipart/form-data; boundary=' . $this->getBoundary()));
    } else {
      $this->getRequest()->getHeaders()->add(new ContentType('application/x-www-form-urlencoded'));
    }

    if (!$this->getRequest()->getCookies()->isEmpty()) {
      $this->getRequest()->getHeaders()->add(new Custom('Cookie', $this->getRequest()->getCookies()->toString()));
    }

    $this->getFilesString();

    if ($this->getRequest()->isMultipart()) {

      $this->addToBody('--'.$this->boundary."--\r\n");
    }

    if ($this->hasRequestBody()) {
      $this->getRequest()->getHeaders()->add(new Custom('Content-Length', $this->contentLength));
    }

    $this->addToHead($this->getRequest()->getHeaders()->toString());

    if ($this->hasRequestBody()) {
      return $this->head . $this->body;
    }

    return $this->head;
  }

  public function __toString()
  {
    return $this->toString();
  }

  protected function getRequest()
  {
    return $this->request;
  }

  protected function getFilesString()
  {

    foreach ($this->getRequest()->getFiles() as $file) {
      $body = sprintf("Content-Disposition: form-data; name=\"%s\"; filename=\"%s\"\r\n", $file->getName(), basename($file->getValue()));
      $body .= sprintf("Content-Type: %s\r\n\r\n", $file->getType());
      $content = $file->getContent();
      $body .= "". $content."\r\n";
      $body = $this->addBoundary($body);
      $this->addToBody($body);
    }
  }

  protected function getHTTPHeader()
  {
    $this->head = \sprintf("%s %s HTTP/%s\r\n", $this->getRequest()->getMethod(), $this->getRequest()->getUrl()->getPathAndQuery(), $this->getRequest()->getVersion());
    $this->head .= \sprintf("Host: %s\r\n", $this->getRequest()->getUrl()->getHostname());
  }

  protected function generateBoundary()
  {
    srand((double) microtime()*1000000);
    $this->boundary = "----------------------------".substr(md5(rand(0,32000)),0,12);
  }

  protected function addBoundary($string)
  {
    return "--". $this->boundary . "\r\n" . $string;
  }

  protected function getParameterString()
  {
    $string = '';
    if ($this->getRequest()->isMultipart()) {
      foreach ($this->getRequest()->getParameters() as $parameter) {

        $param = sprintf('Content-Disposition: form-data; name='."\"%s\"\r\n\r\n%s\r\n", $parameter->getName(), $parameter->getValue());
        $string .= $this->addBoundary($param);
      }
    } else {
      if (!$this->getRequest()->getParameters()->isEmpty()) {
        $string .= $this->getRequest()->getParameters()->toString();
      } elseif ($this->getRequest()->hasBody()) {
        $string .= $this->getRequest()->getBody();
      }
    }

    return $string;
  }

  protected function addToBody($string)
  {
    $this->body .= $string;
    $this->contentLength += strlen($string);
  }

  protected function addToHead($string)
  {
    $this->head .= $string;
  }

  protected function hasRequestBody()
  {
    if (in_array($this->getRequest()->getMethod(), array('POST', 'PUT'))) {
      return true;
    }

    return false;
  }
}
