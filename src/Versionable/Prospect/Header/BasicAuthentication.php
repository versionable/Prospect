<?php

/*
 * This file is part of the Versionable Prospect package.
 *
 * (c) Stuart Lowes <stuart.lowes@versionable.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Versionable\Prospect\Header;

class BasicAuthentication extends Header
{
  public function __construct($username, $password)
  {
    $this->setName('Authorization');
    $this->setValue(\base64_encode(sprintf('%s:%s', $username, $password)));
  }

  public function toString()
  {
    return sprintf('%s: Basic %s', $this->getName(), $this->getValue());
  }
}
