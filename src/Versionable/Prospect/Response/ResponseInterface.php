<?php

namespace Versionable\Prospect\Response;

use Versionable\Prospect\Header\CollectionInterface as HeaderCollectionInterface;
use Versionable\Prospect\Cookie\CollectionInterface as CookieCollectionInterface;

interface ResponseInterface
{
  public function setCode($code);

  public function getCode();

  public function setHeaders(HeaderCollectionInterface $headers);

  public function getHeaders();

  public function getCookies();

  public function setCookies(CookieCollectionInterface $cookies);

  public function setContent($content);

  public function getContent();

  public function parse($responseString);
}
