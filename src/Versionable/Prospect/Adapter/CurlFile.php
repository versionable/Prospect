<?php

namespace Versionable\Prospect\Adapter;

use Versionable\Prospect\Adapter\Exception\CurlFileException;
use Versionable\Prospect\Request\RequestInterface;
use Versionable\Prospect\Response\ResponseInterface;
use Versionable\Prospect\Response\File;

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
        $files = array();

        foreach ($request->getParameters() as $param) {
            $post[$param->getName()] = $param->getValue();
        }

        foreach ($request->getFiles() as $file) {
            $files[$file->getName()] = '@' . $file->getValue() . ';type=' . $file->getType();
        }

        if ($request->getMethod() == 'POST' || $request->getMethod() == 'PUT') {
            if (!empty($files)) {
                $body = array_merge($post, $files);
            } elseif (!empty($post)) {
                $body = \http_build_query($post);
            } else {
                $body = $request->getBody();
            }

            \curl_setopt($this->handle, \CURLOPT_POSTFIELDS, $body);
        }

        if ($request->getMethod() == 'POST' || $request->getMethod() == 'PUT') {
            \curl_setopt ($this->handle, \CURLOPT_POSTFIELDS, $post);
        }

        if (!$request->getCookies()->isEmpty()) {
            \curl_setopt($this->handle, \CURLOPT_COOKIE, $request->getCookies()->toString());
        }

        if (!$request->getHeaders()->isEmpty()) {
            \curl_setopt($this->handle, \CURLOPT_HTTPHEADER, $request->getHeaders()->toArray());
        }

        \curl_setopt($this->handle, \CURLOPT_PORT, $request->getPort());

        \curl_setopt($this->handle, \CURLOPT_FILE, $this->fileHandle);

        $returned = \curl_exec($this->handle);

        $info = \curl_getinfo($this->handle);

        \fclose($this->fileHandle);

        $response->setCode($info['http_code']);

        return $response;
    }
    
    public function createOutFile(File $response)
    {
        $filename = $response->getFilename();

        if($filename == null){
            throw new CurlFileException('The target filename of the response is null');
        }

        $outFileInfo = new \SplFileInfo($filename);
        $parentDir = new \SplFileInfo($outFileInfo->getPath());

        if(!$parentDir->isDir()){
            throw new CurlFileException('The target filename directory does not exist');
        }

        if(!$parentDir->isWritable()){
            throw new CurlFileException('The target filename directory is not writable');
        }

        if($outFileInfo->isFile() && !$outFileInfo->isWritable()){
            throw new CurlFileException('The target filename is not writable');
        }

        $this->fileHandle = \fopen($response->getFilename(), 'w+');
    }
}
