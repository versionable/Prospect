<?php

namespace Versionable\Http\Cookie;

interface CollectionInterface
{
  public function add(CookieInterface $cookie);

  public function remove($name);

  public function get($name);

  public function has($name);

  public function toString();

  public function toArray();

  public function load();
}
