<?php

namespace Versionable\Prospect\Response;

use Versionable\Prospect\Cookie\Cookie;
use Versionable\Prospect\Header\Header;

class FileResponse extends Response implements FileResponseInterface
{
    /**
     * @var string Filename
     */
    private $filename = null;
    private $fileHandle = null;

    public function __construct()
    {
        parent::__construct();
        $this->setFilename(\tempnam(\sys_get_temp_dir(), 'Prospect-Response'));
    }

    public function __destruct()
    {
        if ($this->hasFileHandle()) {
            \fclose($this->getFileHandle());
        }

        if (\file_exists($this->getFilename())) {
            \unlink($this->getFilename());
        }
    }

    public function getFilename()
    {
        ;
        return $this->filename;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    public function getContent()
    {
        return \file_get_contents($this->getFilename());
    }

    public function hasFileHandle()
    {
        if ($this->fileHandle) {
            return true;
        }

        return false;
    }

    public function getFileHandle()
    {
        if (!$this->hasFileHandle()) {
            $this->fileHandle = \fopen($this->getFilename(), 'w+');
        }

        return $this->fileHandle;
    }

    public function headerCallback($ch, $header)
    {
        return $this->parseHeader($header);
    }

    private function parseHeader($string)
    {
        $line = trim($string);

        if (preg_match('@^HTTP/[0-9]\.[0-9] ([0-9]{3})@', $line, $matches)) {
            $this->setStatusCode($matches[1]);
        }
        elseif(false === empty($line))
        {
            list($name, $value) = explode(': ', $line);
            if ($name == 'Set-Cookie') {
                $cookie = Cookie::parse($value);
                $this->getCookies()->add($cookie);
            } else {
                $header = Header::parse($name, $value);
                $this->getHeaders()->add($header);
            }
        }

        return strlen($string);
    }
}