<?php

namespace Versionable\Prospect\Response;

interface ResponseInterface
{
  public function setCode($code);

  public function getCode();

  public function setHeaders($headers);

  public function getHeaders();

  public function setContent($content);

  public function getContent();
}
