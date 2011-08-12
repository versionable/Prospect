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

class CacheControl extends Header
{
    public function __construct($value = null)
    {
        $this->setName('Cache-Control');
        $this->setValue(0);
        parent::__construct($value);
    }

    public function toString()
    {
        return sprintf('%s: max-age=%d', $this->getName(), $this->getValue());
    }
}
