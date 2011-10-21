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

class Header extends HeaderAbstract
{

    public function __construct($name = null, $value = null)
    {
        $this->setName($name);
        $this->setValue($value);
    }


    /**
     * Parses a header string creating a header object and returning it
     * A Custom header will be returned if no specific header class is found
     * @param type $name
     * @param type $value
     */
    public static function parse($name, $value)
    {
        $class_name = '\Versionable\Prospect\Header\\' . \str_replace(' ', '', \ucwords(\str_replace('-', ' ', $name)));

        if (class_exists($class_name)) {
            $header = new $class_name($value);
        } else {
            $header = new self($name, $value);
        }

        return $header;
    }
}