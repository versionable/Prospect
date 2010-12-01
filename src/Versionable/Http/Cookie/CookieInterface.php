<?php

namespace Versionable\Http\Cookie;

interface CookieInterface {

    public function  __toString();

    public function getName();

    public function setName($name);

    public function getValue();

    public function setValue($value);

    public function getExpires();

    public function setExpires($expires);

    public function getPath();

    public function setPath($path);

    public function getDomain();

    public function setDomain($domain);

    public function getSecure();

    public function setSecure($secure);

    public function getHttpOnly();

    public function setHttpOnly($httponly);
}
