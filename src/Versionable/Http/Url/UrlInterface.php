<?php

namespace Versionable\Http\Url;

interface UrlInterface {
  public function toString();

  public function getUrl();

  public function setUrl($url);

  public function getParameters();

  public function setParameters(array $query);

  public function getParameter($name);

  public function setParameter($name, $value);
  
  public function hasParameter($name);
  
  public function getHostname();
  
  public function getScheme();
  
  public function getPort();
  
  public function getUsername();
  
  public function getPassword();
  
  public function getPath();
  
  public function getFragment();
  
  public function getPathAndQuery();
}
