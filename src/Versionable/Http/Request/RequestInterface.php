<?php

namespace Versionable\Http\Request;

use Versionable\Http\Url\UrlInterface;
use Versionable\Http\Cookie\CollectionInterface as CookieCollectionInterface;
use Versionable\Http\Header\CollectionInterface as HeaderCollectionInterface;
use Versionable\Http\Parameter\CollectionInterface as ParameterCollectionInterface;

interface RequestInterface {
  public function setUrl(UrlInterface $url);
  
  public function getUrl();

  public function setParameters(ParameterCollectionInterface $parameters);

  public function getParameters();
  
  public function hasParameters();

  public function setMethod($method);

  public function getMethod();

  public function getHeaders();

  public function setHeaders(HeaderCollectionInterface $headers);
  
  public function hasHeaders();

  public function hasCookies();

  public function getCookies();
  
  public function setCookies(CookieCollectionInterface $collection);
}
