<?php

/*
 * This file is part of the Versionable Prospect package.
 *
 * (c) Stuart Lowes <stuart.lowes@versionable.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Versionable\Prospect\File;

use Versionable\Common\Collection\Map;

class Collection extends Map implements CollectionInterface
{
    /**
     * The HTTP request boundary string
     *
     * @var string
     */
    private $boundary = '';

    /**
     * Adds a File to the collection
     * @param FileInterface $file
     */
    public function add(FileInterface $file)
    {
        $this->put($file->getName(), $file);
    }

    /**
     * Returns as a HTTP formatted string
     * @return string
     */
    public function toString()
    {
        $data = array();
        foreach ($this->elements as $file) {
            $data[] = \sprintf('------------------------------%s', $this->boundary);
            $data[] = $file;
            $data[] = \sprintf('------------------------------%s', $this->boundary);
        }

        return implode("\r\n", $data);
    }

    /**
     * Sets the boundary
     * @param type $boundary
     */
    public function setBoundary($boundary)
    {
        $this->boundary = $boundary;
    }
}
