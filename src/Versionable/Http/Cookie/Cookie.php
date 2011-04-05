<?php

namespace Versionable\Http\Cookie;

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

  public function  __construct($name, $value, \DateTime $expires = null, $path = '/', $domain = null, $secure = false, $httponly = false)
  {
    $this->setName($name);
    $this->setValue($value);
    
    if(false === \is_null($expires))
    {
      $this->setExpires($expires);
    }
    $this->setPath($path);
    $this->setDomain($domain);
    $this->setSecure($secure);
    $this->setHttpOnly($httponly);
  }
  
  public function parse($string)
  {
    $parts = \explode('; ', $string);

    for($i=0; $i < count($parts); $i++)
    {
      if(false !== \strpos($parts[$i], '='))
      {
        list($name, $value) = explode('=', $parts[$i]);
      }
      else
      {
        $name = \str_replace(';', '', $parts[$i]);
        $value = true;
      }

      if ($i==0)
      {
        $this->setName($name);
        $this->setValue($value);
      }
      else
      {
        if($name === 'expires')
        {
          $value = new \DateTime($value);
        }

        $map = array(
          'expires'   => 'setExpires',
          'path'      => 'setPath',
          'domain'    => 'setDomain',
          'secure'    => 'setSecure',
          'httponly'  => 'setHttpOnly'

        );
        $this->$map[$name]($value);          
      }      
    }
  }

  public function __toString()
  {
    return $this->toString();
  }

  public function  toString()
  {
    return sprintf('%s=%s', $this->name, $this->value);
  }

  public function getName()
  {
    return $this->name;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function getValue()
  {
    return $this->value;
  }

  public function setValue($value)
  {
    $this->value = $value;
  }

  public function getExpires()
  {
    return $this->expires;
  }

  public function setExpires(\DateTime $expires)
  {
    $this->expires = $expires;
  }

  public function hasExpired()
  {
    if ($this->expires instanceof \DateTime)
    {
      $now = new \DateTime();

      return ($now > $this->expires);
    }

    return false;
  }

  public function getPath()
  {
    return $this->path;
  }

  public function setPath($path)
  {
    $this->path = empty($path) ? '/' : $path;
  }

  public function getDomain()
  {
    return $this->domain;
  }

  public function setDomain($domain)
  {
    $this->domain = $domain;
  }

  public function isSecure()
  {
    return $this->secure;
  }

  public function setSecure($secure)
  {
    $this->secure = (boolean)$secure;
  }

  public function isHttpOnly()
  {
    return $this->httponly;
  }

  public function setHttpOnly($httponly)
  {
    $this->httponly = (boolean)$httponly;
  }
}