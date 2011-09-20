<?php

/*
 * This file is part of the Versionable Prospect package.
 *
 * (c) Stuart Lowes <stuart.lowes@versionable.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Versionable\Prospect\Cookie;

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

    /**
     * The Cookie name
     * @var string
     */
    private $name;
    /**
     * The Cookie value
     * @var string
     */
    private $value;
    /**
     * The date when the Cookie is no longer valid
     * @var \DateTime
     */
    private $expires = null;
    /**
     * Cookie path
     * @var string
     */
    private $path = '/';
    /**
     * Cookie domain
     * @var string
     */
    private $domain = '';
    /**
     * Determines whether a Cookie is marked as secure
     * @var boolean
     */
    private $secure = false;
    /**
     * Determines whether a Cookie should be marked as httponly
     * @var type
     */
    private $httponly = false;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $value
     * @param \DateTime $expires
     * @param string $path
     * @param string $domain
     * @param boolean $secure
     * @param boolean $httponly
     */
    public function __construct($name, $value, \DateTime $expires = null, $path = '/', $domain = null, $secure = false, $httponly = false)
    {
        $this->setName($name);
        $this->setValue($value);

        if (false === \is_null($expires)) {
            $this->setExpires($expires);
        }
        $this->setPath($path);
        $this->setDomain($domain);
        $this->setSecure($secure);
        $this->setHttpOnly($httponly);
    }

    /**
     * Parses a raw Cookie string
     * @param type $string
     * @return Cookie
     */
    public static function parse($string)
    {
        /**
         * @todo validate the cookie string before trying to process it
         */
        $parts = \explode('; ', $string);



        for ($i = 0; $i < count($parts); $i++) {
            if (false !== \strpos($parts[$i], '=')) {
                list($name, $value) = explode('=', $parts[$i]);
            } else {
                $name = \str_replace(';', '', $parts[$i]);
                $value = true;
            }

            if ($i == 0) {
                $cookie = new self($name, $value);
            } else {
                if ($name === 'expires') {
                    $value = new \DateTime($value);
                }

                $map = array(
                    'expires' => 'setExpires',
                    'path' => 'setPath',
                    'domain' => 'setDomain',
                    'secure' => 'setSecure',
                    'httponly' => 'setHttpOnly'
                );
                $cookie->$map[$name]($value);
            }
        }

        return $cookie;
    }

    /**
     * Returns a HTTP formatted Cookie string
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Returns a HTTP formatted Cookie string
     * @return string
     */
    public function toString()
    {
        return sprintf('%s=%s', $this->name, $this->value);
    }

    /**
     * Returns the name of the cookie
     * @return type
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name of the Cookie
     * @param type $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the value of the Cookie
     * @return type
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value of the Cookie
     * @param type $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Returns the expires date
     * @return \DateTime
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * Sets the expires date
     * @param \DateTime $expires
     */
    public function setExpires(\DateTime $expires)
    {
        $this->expires = $expires;
    }

    /**
     * Returns whether the Cookie has expired
     * @return boolean
     */
    public function hasExpired()
    {
        if ($this->expires instanceof \DateTime) {
            $now = new \DateTime();

            return ($now > $this->expires);
        }

        return false;
    }

    /**
     * Returns the path
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the Cookie path
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = empty($path) ? '/' : $path;
    }

    /**
     * Gets the Cookie domain
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Sets the Cookie domain
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * Returns whether the Cookie is marked as secure
     * @return boolean
     */
    public function isSecure()
    {
        return $this->secure;
    }

    /**
     * Sets whether a cookie is marked as secure
     * @param boolean $secure
     */
    public function setSecure($secure)
    {
        $this->secure = (boolean) $secure;
    }

    /**
     * Returns whether the Cookie is marked as secure
     * @return boolean
     */
    public function isHttpOnly()
    {
        return $this->httponly;
    }

    /**
     * Sets whether a Cookie is marked as secure
     * @param boolean $httponly
     */
    public function setHttpOnly($httponly)
    {
        $this->httponly = (boolean) $httponly;
    }
}