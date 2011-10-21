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

use Versionable\Common\Collection\Map;

class Collection extends Map implements CollectionInterface
{
    /**
     * Adds a Parameter to the Ccollection
     * @param ParameterInterface $parameter
     */
    public function add(ParameterInterface $parameter)
    {
        $this->put($parameter->getName(), $parameter);
    }

    /**
     * Returns as per toString
     * @see toString()
     * @return type
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Returns the Collection as a query string
     * @return type
     */
    public function toString()
    {
        $parameters = array();

        foreach ($this->elements as $parameter) {
            $parameters[$parameter->getName()] = $parameter->getValue();
        }

        return http_build_query($parameters);
    }

    /**
     * Tests to see if the element is valid.
     * Only ParameterInterface instances are value
     * @param ParameterInterface $element
     * @return type
     */
    public function isValid($element)
    {
        if ($element instanceof ParameterInterface) {
            return true;
        }

        return false;
    }
}
