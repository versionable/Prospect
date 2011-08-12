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

class Parameter implements ParameterInterface
{
    /**
     * The name of the Parameter
     * @var string
     */
    private $name;

    /**
     * The value of the parameter
     * @var string
     */
    private $value;

    /**
     * Constructor, accepts a name and value
     * @param type $name
     * @param type $value
     */
    public function __construct($name, $value)
    {
        $this->setName($name);
        $this->setValue($value);
    }

    /**
     * Returns as per toString()
     * @see toString()
     * @return type
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Returns as a formatted string
     * The name and value are urlencoded
     * @return type
     */
    public function toString()
    {
        return sprintf("%s=%s", urlencode($this->getName()), urlencode($this->getValue()));
    }

    /**
     * Returns the Parameter name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the Parameter name
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the Parameter value
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the Parameter value
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
