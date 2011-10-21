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

abstract class HeaderAbstract implements HeaderInterface
{
    /**
     * Header name
     * @var string
     */
    private $name;

    /**
     * Header value
     * @var type
     */
    private $value;

    /**
     * Constructor
     * @param scalar $value
     */
    public function __construct($value = null)
    {
        if (!is_null($value)) {
            $this->setValue($value);
        }
    }

    /**
     * Sets the Header name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the Header name
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the Header value
     * @return scalar
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the Header value
     * @param type $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Returns the formatted Header string
     * @return type
     */
    public function toString()
    {
        return sprintf('%s: %s', $this->name, $this->value);
    }

    /**
     * Returns as toString()
     * @return type
     */
    public function __toString()
    {
        return $this->toString();
    }
}
