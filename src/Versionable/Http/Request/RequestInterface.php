<?php

namespace Versionable\Http\Request;

use Versionable\Http\Url\UrlInterface;
use Versionable\Http\Cookie\Collection as CookieCollectionInterface;
use Versionable\Http\Header\Collection as HeaderCollectionInterface;
use Versionable\Http\Parameter\Collection as ParameterCollectionInterface;

interface RequestInterface {
  public function setUrl(UrlInterface $url);
  
  public function getUrl();

  public function setParameters(ParameterCollectionInterface $parameters);

  public function getParameters();
  
  public function setMethod($method);

  public function getMethod();

  public function getHeaders();

  public function setHeaders(HeaderCollectionInterface $headers);

  public function hasCookies();

  public function getCookies();
  
  public function setCookies(CookieCollectionInterface $collection);
}
