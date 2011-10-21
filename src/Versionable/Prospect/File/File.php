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

class File implements FileInterface
{
    /**
     * The Content Type
     *
     * @var string
     */
    private $type = '';

    /**
     * The name of the File to be used in the Request
     *
     * @var string
     */
    private $name = '';

    /**
     * The actual File name
     *
     * @var string
     */
    private $value = '';

    /**
     * Constructor
     * @param string $name
     * @param string $value
     * @param string $type
     */
    public function __construct($name, $value, $type)
    {
        $this->setName($name);
        $this->setValue($value);
        $this->setType($type);
    }

    /**
     * Returns the File name. This is the name used in the HTTP request
     * @return type
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the file name
     * @param type $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the File value. This is the filename of the File
     * e.g. /tmp/1234.txt
     * @return type
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value. This is the filename.
     * @param type $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Returns the content of the File
     * @return type
     */
    public function getContent()
    {
        return \file_get_contents($this->getValue());
    }

    /**
     * Returns the File contents
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Returns the File contents
     *
     * @return string
     */
    public function toString()
    {
        return $this->getContent();
    }

    /**
     * Returns the Content Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the Content Type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
