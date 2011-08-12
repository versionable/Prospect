<?php

/*
 * This file is part of the Versionable Prospect package.
 *
 * (c) Stuart Lowes <stuart.lowes@versionable.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Versionable\Prospect\Parameter;

interface ParameterInterface
{
    public function __toString();

    public function toString();

    public function getName();

    public function setName($name);

    public function getValue();

    public function setValue($value);
}
