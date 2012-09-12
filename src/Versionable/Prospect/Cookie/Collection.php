<?php

namespace Versionable\Prospect\Cookie;

use Versionable\Common\Collection\Map;

class Collection extends Map implements CollectionInterface
{
  public function add(CookieInterface $cookie)
  {
    $this->put($cookie->getName(), $cookie);
  }

  public function isValid($element)
  {
    if ($element instanceof CookieInterface) {
      return true;
    }

    return false;
  }

  public function parse($string)
  {
    $cookie = new Cookie('','');
    $cookie->parse($string);
    $this->add($cookie);
  }

  public function toString()
  {
    $cookies = array();

    foreach ($this->elements as $cookie) {
      $cookies[] = $cookie;
    }

    return implode(';', $cookies);
  }
}
