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

class Accept extends Header
{
    public function __construct($value = null)
    {
        $this->setName('Accept');
        $this->setValue('gzip;q=1.0, identity; q=0.5, *;q=0');
        parent::__construct($value);
    }
}
