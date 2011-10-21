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

class ContentType extends HeaderAbstract
{
    public function __construct($value)
    {
        $this->setName('Content-Type');
        $this->setValue($value);
    }
}
