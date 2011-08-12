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

class AcceptCharset extends Header
{
    /**
     * Constructor
     * @param scalar $value
     */
    public function __construct($value = null)
    {
        $this->setName('Accept-Charset');
        $this->setValue('ISO-8859-1,utf-8;q=0.7,*;q=0.7');
        parent::__construct($value);
    }
}
