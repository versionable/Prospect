<?php

namespace Versionable\Prospect\Adapter;

use Versionable\Prospect\Request\RequestInterface;
use Versionable\Prospect\Response\ResponseInterface;
use Versionable\Prospect\Parameter\FileIterface;
use Versionable\Prospect\Header\Header;
use Versionable\Prospect\Header\Collection as HeaderCollection;
use Versionable\Prospect\Cookie\Collection as CookieCollection;

class CurlFile extends Curl
{
    protected $fileHandle;
    
    public function initialize()
    {
        $this->handle = curl_init();
        $this->setOption(\CURLOPT_RETURNTRANSFER, false);
        $this->setOption(\CURLOPT_NOBODY, null);
        $this->setOption(\CURLOPT_FOLLOWLOCATION, true);
        $this->setOption(\CURLOPT_MAXREDIRS, 5);
        $this->setOption(\CURLOPT_HEADER, false);

        foreach ($this->options as $name => $value) {
            \curl_setopt($this->handle, $name, $value);
        }
    }

    public function call(RequestInterface $request, ResponseInterface $response)
    {
        $this->initialize();
        $this->createOutFile($response);

        \curl_setopt($this->handle, CURLOPT_URL, $request->getUrl());

        if ($request->getMethod() == 'GET') {
            \curl_setopt($this->handle, \CURLOPT_HTTPGET, true);
        } elseif ($request->getMethod() == 'POST') {
            \curl_setopt($this->handle, \CURLOPT_POST, true);
        } else {
            \curl_setopt($this->handle, \CURLOPT_CUSTOMREQUEST, $request->getMethod());
        }

        $post = array();
        if ($request->hasParameters()) {
            foreach ($request->getParameters() as $param) {
                $post[$param->getName()] = $param->getValue();
            }
        }

        if ($request->hasFiles()) {
            foreach ($request->getFiles() as $file) {
                $post[$file->getName()] = '@' . $file->getValue() . ';type=' . $file->getType();
            }
        }

        if ($request->getMethod() == 'POST' || $request->getMethod() == 'PUT') {
            \curl_setopt ($this->handle, \CURLOPT_POSTFIELDS, $post);
        }

        if ($request->hasCookies()) {
            \curl_setopt($this->handle, \CURLOPT_COOKIE, $request->getCookies()->toString());
        }

        if ($request->hasHeaders()) {
            \curl_setopt($this->handle, \CURLOPT_HTTPHEADER, $request->getHeaders()->toArray());
        }

        \curl_setopt($this->handle, \CURLOPT_PORT, $request->getPort());

        \curl_setopt($this->handle, \CURLOPT_FILE, $this->fileHandle);

        $returned = \curl_exec($this->handle);

        \fclose($this->fileHandle);

        $response->parse($returned);

        return $response;
    }

    protected function createOutFile(ResponseInterface $response)
    {
        $this->fileHandle = \fopen($response->getFilename(), 'w+');
    }
}