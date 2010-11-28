<?php

namespace Versionable\HttpClient\Request;

use Versionable\HttpClient\Cookie\Collection as CookieCollectionInterface;
use Versionable\HttpClient\Header\Collection as HeaderCollectionInterface;
use Versionable\HttpClient\Url\UrlInterface;
use Versionable\HttpClient\File\FileInterface;

interface RequestInterface {
  public function setUrl(UrlInterface $url);
  
  public function getUrl();

  public function setParameters(array $parameters);

  public function getParameter($name);

  public function setParameter($name, $value);

  public function hasParameter($name);

  public function getParameters();

  public function addFile($name, FileInterface $file);

  public function getFiles();

  public function setFiles($files);
  
  public function hasFiles();

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
