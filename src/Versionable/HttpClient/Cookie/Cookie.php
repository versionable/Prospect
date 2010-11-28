<?php

namespace Versionable\HttpClient\Cookie;

class Cookie implements CookieInterface
{

    /**
     * Sets a cookie.
     *
     * @param  string  $name     The cookie name
     * @param  string  $value    The value of the cookie
     * @param  string  $expires  The time the cookie expires
     * @param  string  $path     The path on the server in which the cookie will be available on
     * @param  string  $domain   The domain that the cookie is available
     * @param  bool    $secure   Indicates that the cookie should only be transmitted over a secure HTTPS connection from the client
     * @param  bool    $httponly The cookie httponly flag
     */

    const DATE_FORMAT = 'D, d-M-Y H:i:s T';

    protected $name;
    protected $value;
    protected $expires = null;
    protected $path = '/';
    protected $domain = '';
    protected $secure = false;
    protected $httponly = false;

    public function  __construct($name, $value, $expires = null, $path = '/', $domain = null, $secure = false, $httponly = false) {
      $this->setName($name);
      $this->setValue($value);
      $this->setExpires($expires);
      $this->setPath($path);
      $this->setDomain($domain);
      $this->setSecure($secure);
      $this->setHttpOnly($httponly);
    }

    public function  __toString() {
      return sprintf('%s=%s', $this->name, $this->value);
    }

    public function getName() {
      return $this->name;
    }

    public function setName($name) {
      $this->name = $name;
    }

    public function getValue() {
      return $this->value;
    }

    public function setValue($value) {
      $this->value = $value;
    }

    public function getExpires() {
      return $this->expires;
    }

    public function setExpires($expires) {
      $this->expires = $expires;
    }

    public function getPath() {
      return $this->path;
    }

    public function setPath($path) {
      $this->path = empty($path) ? '/' : $path;
    }

    public function getDomain() {
      return $this->domain;
    }

    public function setDomain($domain) {
      $this->domain = $domain;
    }

    public function getSecure() {
      return $this->secure;
    }

    public function setSecure($secure) {
      $this->secure = (boolean)$secure;
    }

    public function getHttpOnly() {
      return $this->httponly;
    }

    public function setHttpOnly($httponly) {
      $this->httponly = (boolean)$httponly;
    }

}