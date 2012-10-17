<?php

namespace Versionable\Prospect\Url;

class Url implements UrlInterface
{

  protected $scheme = 'http';

  protected $hostname = 'localhost';

  protected $port = 80;

  protected $username = null;

  protected $password = null;

  protected $path = '/';

  protected $parameters = array();

  protected $fragment = '';

  protected $query_separator = '&';

  public function __construct($url = null, $parameters = array())
  {
    $this->setParameters($parameters);

    if (null !== $url) {
        $this->setUrl($url);
    }
  }

  public function __toString()
  {
    return $this->toString();
  }

  public function toString()
  {
    return $this->getUrl();
  }

  /**
   *
   * TODO: Return assembled string from other properties
   *
   * @return string
   */
  public function getUrl()
  {
    return $this->buildUrl();
  }

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

      if (! empty($components['query'])) {
        parse_str($components['query'], $parameters);
        $this->setParameters(array_merge($this->parameters, $parameters));
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

  public function setParameters(array $parameters)
  {
    $this->parameters = $parameters;
  }

  public function getParameters()
  {
    return $this->parameters;
  }

  public function getParameter($name)
  {
    if ($this->hasParameter($name)) {
      return $this->parameters[$name];
    }

    return null;
  }

  public function setParameter($name, $value)
  {
    $this->parameters[$name] = $value;
  }

  public function hasParameter($name)
  {
    return isset($this->parameters[$name]);
  }

  public function setHostname($hostname)
  {
    $this->hostname = $hostname;
  }

  public function getHostname()
  {
    return $this->hostname;
  }

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

  public function getScheme()
  {
    return $this->scheme;
  }

  public function setPort($port)
  {
    if (\is_numeric($port)) {
      $this->port = $port;
    }
  }

  public function getPort()
  {
    return $this->port;
  }

  public function setUsername($username)
  {
    $this->username = $username;
  }

  public function getUsername()
  {
    return $this->username;
  }

  public function setPassword($password)
  {
    $this->password = $password;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function setPath($path)
  {
    if (empty($path)) {
      $path = '/';
    }

    $this->path = $path;
  }

  public function getPath()
  {
    return $this->path;
  }

  public function setFragment($fragment)
  {
    $this->fragment = $fragment;
  }

  public function getFragment()
  {
    return $this->fragment;
  }

  public function getPathAndQuery()
  {
    $path = $this->path;
    $query = $this->getQuery();
    if (false === empty($query)) {
      $path .= '?'. $this->getQuery();
    }

    return $path;
  }

  public function getQuery()
  {
    $query = '';
    if (count($this->parameters) > 0) {
      $query = http_build_query($this->getParameters());
    }

    return $query;
  }

  protected function buildUrl()
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

    $keys = array('user','pass','port','path','query','fragment');

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
      .((isset($components['user'])) ? $components['user'] . ((isset($components['pass'])) ? ':' . $components['pass'] : '') .'@' : '')
      .((isset($components['host'])) ? $components['host'] : '')
      .((isset($components['port'])) ? ':' . $components['port'] : '')
      .((isset($components['path'])) ? $components['path'] : '')
      .((!empty($components['query'])) ? '?' . $components['query'] : '')
      .((isset($components['fragment'])) ? '#' . $components['fragment'] : '');
  }
}
