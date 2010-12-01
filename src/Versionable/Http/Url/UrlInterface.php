<?php

namespace Versionable\Http\Url;

interface UrlInterface {
  public function toString();

  public function getUrl();

  public function setUrl($url);

  public function getParameters();

  public function setParameters(array $parameters);

  public function getParameter($name);

  public function setParameter($name, $value);
  
  public function hasParameter($name);
}
