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

interface UrlInterface
{
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
