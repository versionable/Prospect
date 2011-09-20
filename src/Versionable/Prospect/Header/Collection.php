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

use Versionable\Common\Collection\Map;

class Collection extends Map implements CollectionInterface
{
    /**
     * Adds a header to the Collection
     * @param HeaderInterface $header
     */
    public function add(HeaderInterface $header)
    {
        $this->put($header->getName(), $header);
    }

    /**
     * Returns the formatted Headers
     * @return string
     */
    public function toString()
    {
        $data = '';
        foreach ($this as $header) {
            $data .= $header->toString() . "\r\n";
        }

        return $data;
    }
}
