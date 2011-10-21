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

interface FileInterface
{
    public function __construct($name, $value, $type);

    public function __toString();

    public function toString();

    public function getContent();

    public function getType();

    public function setType($type);
}
