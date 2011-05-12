<?php

namespace Versionable\Prospect\Request;

use Versionable\Prospect\Url\UrlInterface;
use Versionable\Prospect\Cookie\CollectionInterface as CookieCollectionInterface;
use Versionable\Prospect\Header\CollectionInterface as HeaderCollectionInterface;
use Versionable\Prospect\Parameter\CollectionInterface as ParameterCollectionInterface;
use Versionable\Prospect\File\CollectionInterface as FileCollectionInterface;

interface RequestInterface
{
  public function setUrl(UrlInterface $url);

  public function getUrl();

  public function setBody($body);

  public function getBody();

  public function setParameters(ParameterCollectionInterface $parameters);

  public function getParameters();

  public function setFiles(FileCollectionInterface $files);

  public function getFiles();

  public function setMethod($method);

  public function getMethod();

  public function getHeaders();

  public function setHeaders(HeaderCollectionInterface $headers);

  public function getCookies();

  public function setCookies(CookieCollectionInterface $collection);

  public function setPort($port);

  public function getPort();

  public function setVersion($version);

  public function getVersion();
}
