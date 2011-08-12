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

class DesktopUserAgent extends Header
{
    public function __construct($value = null)
    {
        $this->setName('User-Agent');
        $this->setValue('Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        parent::__construct($value);
    }
}
