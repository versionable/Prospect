<?php

/*
 * This file is part of the Versionable Prospect package.
 *
 * (c) Stuart Lowes <stuart.lowes@versionable.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Versionable\Prospect\Url;

class Url implements UrlInterface
{
    /**
     * Url scheme, .e.g. http
     * @var type
     */
    private $scheme = 'http';

    /**
     * Hostname
     * @var string
     */
    private $hostname = 'localhost';

    /**
     * Port number
     * @var intger
     */
    private $port = 80;

    /**
     * Username
     * @var string
     */
    private $username = null;

    /**
     * Pasword
     * @var string
     */
    private $password = null;

    /**
     * Path
     * @var string
     */
    private $path = '/';

    /**
     * Query string parameters
     * @var array
     */
    private $parameters = array();

    /**
     * The hash # value
     * @var type
     */
    private $fragment = '';

    /**
     * The character separating the query string parameters
     * @var type
     */
    private $query_separator = '&';

    /**
     * Constructor
     * @param string $url
     * @param array $parameters
     */
    public function __construct($url = null, $parameters = array())
    {
        $this->setParameters($parameters);

        if (null !== $url) {
            $this->setUrl($url);
        }
    }

    /**
     * Returns the url
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Returns the url
     * @return string
     */
    public function toString()
    {
        return $this->getUrl();
    }

    /**
     *
     * Returns the assembled url string
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->buildUrl();
    }

    /**
     * Sets the url string
     * @param string $url
     */
    public function setUrl($url)
    {

        if (filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED) === false) {
            throw new \RuntimeException('Not a valid Url');
        }

        $components = parse_url($url);
        if (is_array($components)) {
            if (isset($components['user'])) {
                $this->setUsername($components['user']);
                if (isset($components['pass'])) {
                    $this->setPassword($components['pass']);
                }
            }

            $this->setScheme($components['scheme']);

            if (!empty($components['query'])) {
                $this->setParameters(array_merge($this->parameters, explode($this->query_separator, $components['query'])));
            }

            $this->setHostname($components['host']);

            if (isset($components['path'])) {
                $this->setPath($components['path']);
            }

            if (isset($components['port'])) {
                $this->setPort($components['port']);
            }

            $this->setScheme($components['scheme']);

            if (isset($components['fragment'])) {
                $this->setFragment($components['fragment']);
            }
        }
    }

    /**
     * Sets url parameters that will be used for the query string
     * @param array $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Returns the parameters
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Returns a specific parameter
     * @param string $name
     * @return string
     */
    public function getParameter($name)
    {
        if ($this->hasParameter($name)) {
            return $this->parameters[$name];
        }

        return null;
    }

    /**
     * Sets a specfic parameter
     * @param string $name
     * @param string $value
     */
    public function setParameter($name, $value)
    {
        $this->parameters[$name] = $value;
    }

    /**
     * Returns true if a parameter has been set otherwise false
     * @param type $name
     * @return boolean
     */
    public function hasParameter($name)
    {
        return isset($this->parameters[$name]);
    }

    /**
     * Sets the host/domain name
     * @param type $hostname
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
    }

    /**
     * Returns the host/domain name
     * @return type
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * Sets the url scheme, e.g. http or https
     * @param type $scheme
     */
    public function setScheme($scheme)
    {
        if ($this->getPort() == 80 || $this->getPort() == 443) {
            if ($scheme == 'http') {
                $this->setPort(80);
            } elseif ($scheme == 'https') {
                $this->setPort(443);
            }
        }

        $this->scheme = $scheme;
    }

    /**
     * Returns the url scheme
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * sets the port number
     * @param integer $port
     */
    public function setPort($port)
    {
        if (\is_numeric($port)) {
            $this->port = (int)$port;
        }
    }

    /**
     * Returns the set port
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Sets the username
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Returns the set username
     * @return type
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets the password
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Returns the password
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the url path
     * @param string $path
     */
    public function setPath($path)
    {
        if (empty($path)) {
            $path = '/';
        }

        $this->path = $path;
    }

    /**
     * Returns the url path
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the fragent / hash
     * @param string $fragment
     */
    public function setFragment($fragment)
    {
        $this->fragment = $fragment;
    }

    /**
     * Returns the fragment / hash
     * @return string
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * Returns the aseembled path and query string
     * /foo/bar/?a=b
     * @return string
     */
    public function getPathAndQuery()
    {
        $path = $this->path;
        $query = $this->getQuery();
        if (false === empty($query)) {
            $path .= '?' . $this->getQuery();
        }

        return $path;
    }

    /**
     * Returns the query string containing all set parameters
     * @return type
     */
    public function getQuery()
    {
        $query = '';
        if (count($this->parameters) > 0) {
            $query = http_build_query($this->getParameters());
        }

        return $query;
    }

    /**
     * Builds a full url string from all url properties
     * @return string
     */
    private function buildUrl()
    {
        $components = array(
            'scheme' => $this->getScheme(),
            'host' => $this->getHostname(),
            'port' => $this->getPort(),
            'user' => $this->getUsername(),
            'pass' => $this->getPassword(),
            'path' => $this->getPath(),
            'query' => $this->getQuery(),
            'fragment' => $this->getFragment()
        );


        $keys = array('user', 'pass', 'port', 'path', 'query', 'fragment');

        foreach ($keys as $key) {
            if (empty($components[$key])) {
                unset($components[$key]);
            }
        }

        if ($components['port'] == 80) {
            unset($components['port']);
        }

        return
        ((isset($components['scheme'])) ? $components['scheme'] . '://' : '')
        . ((isset($components['user'])) ? $components['user'] . ((isset($components['pass'])) ? ':' . $components['pass'] : '') . '@' : '')
        . ((isset($components['host'])) ? $components['host'] : '')
        . ((isset($components['port'])) ? ':' . $components['port'] : '')
        . ((isset($components['path'])) ? $components['path'] : '')
        . ((!empty($components['query'])) ? '?' . $components['query'] : '')
        . ((isset($components['fragment'])) ? '#' . $components['fragment'] : '');
    }

}
