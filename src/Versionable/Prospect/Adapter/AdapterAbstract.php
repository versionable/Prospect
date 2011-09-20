<?php

/*
 * This file is part of the Versionable Prospect package.
 *
 * (c) Stuart Lowes <stuart.lowes@versionable.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Versionable\Prospect\Adapter;

abstract class AdapterAbstract
{
    /**
     * Array of set options
     *
     * @var type
     */
    private $options = array();

    /**
     * Sets an adapter option
     *
     * @param string $name The name of the option
     * @param scalar $value The value of the option
     * @return boolean Returns if option name is a valid string otherwise false
     */
    public function setOption($name, $value)
    {
        if (!empty($name)) {
            $this->options[$name] = $value;

            return true;
        }

        return false;
    }

    /**
     * Returns the value of an option if set otherwise null
     *
     * @param string $name
     * @return scalar|null
     */
    public function getOption($name)
    {
        if ($this->hasOption($name)) {
            return $this->options[$name];
        }

        return null;
    }

    /**
     * Returns the array of specified options
     * @return array Array of options
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Returns true if the option exists otherwise false
     *
     * @param string $name
     * @return boolean
     */
    public function hasOption($name)
    {
        if (isset($this->options[$name])) {
            return true;
        }

        return false;
    }

}
