<?php

namespace Versionable\HttpClient\Request;

use Versionable\HttpClient\Url\UrlInterface;
use Versionable\HttpClient\Cookie\Collection as CookieCollectionInterface;
use Versionable\HttpClient\Header\Collection as HeaderCollectionInterface;
use Versionable\HttpClient\Parameter\Collection as ParameterCollectionInterface;

interface RequestInterface {
  public function setUrl(UrlInterface $url);
  
  public function getUrl();

  public function setParameters(ParameterCollectionInterface $parameters);

  public function getParameters();

  public function getMethod();

  public function getHeaders();

  public function setHeaders(HeaderCollectionInterface $headers);

  public function hasCookies();

  public function getCookies();
  
  public function setCookies(CookieCollectionInterface $collection);

  public function setMethod($method);
  
  public function getUserAgent();

  public function setUserAgent(UserAgentInteface $agent);
}
