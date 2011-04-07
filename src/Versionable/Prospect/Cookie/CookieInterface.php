<?php

namespace Versionable\Prospect\Cookie;

interface CookieInterface
{
    public function  __toString();

    public function toString();

    public function getName();

    public function setName($name);

    public function getValue();

    public function setValue($value);

    public function getExpires();

    public function setExpires(\DateTime $expires);

    public function getPath();

    public function setPath($path);

    public function getDomain();

    public function setDomain($domain);

    public function isSecure();

    public function setSecure($secure);

    public function isHttpOnly();

    public function setHttpOnly($httponly);
}
