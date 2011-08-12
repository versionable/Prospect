<?php

/*
 * This file is part of the Versionable Prospect package.
 *
 * (c) Stuart Lowes <stuart.lowes@versionable.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Versionable\Prospect\Cookie;

use Versionable\Common\Collection\Map;

class Collection extends Map implements CollectionInterface
{
    /**
     * Adds a cookie to the collection
     *
     * @param CookieInterface $cookie
     */
    public function add(CookieInterface $cookie)
    {
        $this->put($cookie->getName(), $cookie);
    }

    /**
     * Determines whether an item is valid or not. Returns true if valid
     * otherwise false
     *
     * @param CookieInterface $element
     * @return boolean
     */
    public function isValid($element)
    {
        if ($element instanceof CookieInterface) {
            return true;
        }

        return false;
    }

    /**
     * Parses a cookie string and adds it to the collection
     * Returns true on success otherwise false
     *
     * @param string $string
     * @return boolean
     */
    public function parse($string)
    {
        $cookie = new Cookie('', '');

        if($cookie->parse($string)) {
            $this->add($cookie);

            return true;
        }

        return false;
    }

    /**
     * Returns a correctly formatted HTTP Cookie string
     *
     * @return string
     */
    public function toString()
    {
        $cookies = array();

        foreach ($this->elements as $cookie) {
            $cookies[] = $cookie->toString();
        }

        return implode(';', $cookies);
    }

}
