<?php

/*
 * This file is part of the Versionable Prospect package.
 *
 * (c) Stuart Lowes <stuart.lowes@versionable.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Versionable\Prospect\Request;

use Versionable\Prospect\Header\Header;
use Versionable\Prospect\Header\ContentType;

class StringBuilder
{
    /**
     * The Request object
     * @var RequestInterface
     */
    private $request = null;

    /**
     * The headers string
     * @var string
     */
    private $headers = '';

    /**
     * The body string
     * @var string
     */
    private $content = "";

    /**
     * The content length
     * @var integer
     */
    private $contentLength = 0;

    /**
     * The boundady string
     * @var string
     */
    private $boundary = '';

    /**
     * Sets the Request that is going to created into the raw HTTP request string
     * @param RequestInterface $request
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     *
     * @return type
     */
    private function getRequest()
    {
        return $this->request;
    }

    /**
     * Sets the part separation boundary string
     * @param type $boundary
     */
    public function setBoundary($boundary)
    {
        $this->boundary = $boundary;
    }

    /**
     * Returns the boundary string
     * @return string
     */
    public function getBoundary()
    {
        return $this->boundary;
    }

    /**
     * Returns the raw HTTP request string created from the Request object
     * @return string
     */
    public function toString()
    {
        return $this->build();
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getContent()
    {
        if ($this->getBoundary() === '') {

            $this->generateBoundary();
        }
        
        return $this->getParameterString() . $this->getFilesString();
    }

    public function build()
    {
        $this->data = '';
        $this->content = "\r\n";

        if (null === $this->getRequest() || null === $this->getRequest()->getUrl()) {
            throw new \RuntimeException('No getUrl() set for request');
        }

        if ($this->getBoundary() === '') {

            $this->generateBoundary();
        }

        $this->getHTTPHeader();

        if ($this->getRequest()->isMultipart()) {
            $this->getRequest()->getHeaders()->add(new ContentType('multipart/form-data; boundary=' . $this->getBoundary()));
        } else if(false === $this->getRequest()->getHeaders()->containsKey('Content-Type')) {
            $this->getRequest()->getHeaders()->add(new ContentType('application/x-www-form-urlencoded'));
        }

        if (!$this->getRequest()->getCookies()->isEmpty()) {
            $this->getRequest()->getHeaders()->add(new Header('Cookie', $this->getRequest()->getCookies()->toString()));
        }

        $content = $this->getContent();

        $this->addToContent($content);

        if ($this->getRequest()->isMultipart()) {

            $this->addToContent('--' . $this->boundary . "--\r\n");
        }

        if ($this->hasRequestBody()) {
            $this->getRequest()->getHeaders()->add(new Header('Content-Length', $this->contentLength));
        }

        $this->addToHeaders($this->getRequest()->getHeaders()->toString());

        if ($this->hasRequestBody()) {
            return $this->headers . $this->content;
        }

        return $this->headers;
    }

    /**
     * Returns the same as toString()
     * @return type
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Creates the parts for any Files in the Request
     */
    private function getFilesString()
    {
        $string = '';

        foreach ($this->getRequest()->getFiles() as $file) {
            $body = sprintf("Content-Disposition: form-data; name=\"%s\"; filename=\"%s\"\r\n", $file->getName(), basename($file->getValue()));
            $body .= sprintf("Content-Type: %s\r\n\r\n", $file->getType());
            $content = $file->getContent();
            $body .= "" . $content . "\r\n";
            $body = $this->addBoundary($body);
            $string .= $body;
        };

        return $string;
    }

    /**
     * Creates the HTTP headers part of the request
     */
    private function getHTTPHeader()
    {
        $this->headers = \sprintf("%s %s HTTP/%s\r\n", $this->getRequest()->getMethod(), $this->getRequest()->getUrl()->getPathAndQuery(), $this->getRequest()->getVersion());
        $this->headers .= \sprintf("Host: %s\r\n", $this->getRequest()->getUrl()->getHostname());
    }

    /**
     * Generates a boundary string
     */
    private function generateBoundary()
    {
        srand((double) microtime() * 1000000);
        $this->boundary = "----------------------------" . substr(md5(rand(0, 32000)), 0, 12);
    }

    /**
     * Adds the boundary to a string
     * @param string $string
     * @return string
     */
    private function addBoundary($string)
    {
        return "--" . $this->boundary . "\r\n" . $string;
    }

    /**
     * Creates a string from any set parameters
     * @return type
     */
    private function getParameterString()
    {
        $string = '';
        if ($this->getRequest()->isMultipart()) {
            foreach ($this->getRequest()->getParameters() as $parameter) {

                $param = sprintf('Content-Disposition: form-data; name=' . "\"%s\"\r\n\r\n%s\r\n", $parameter->getName(), $parameter->getValue());
                $string .= $this->addBoundary($param);
            }
        } else {
            if (!$this->getRequest()->getParameters()->isEmpty()) {
                $string .= $this->getRequest()->getParameters()->toString();
            } elseif ($this->getRequest()->hasBody()) {
                $string .= $this->getRequest()->getBody();
            }
        }

        return $string;
    }

    /**
     * Adds the string to the assembled body string
     * And adds the length the content lenght
     * @param string $string
     */
    private function addToContent($string)
    {
        $this->content .= $string;
        $this->contentLength += strlen($string);

    }

    /**
     * Adds the string to the headers
     * @param string $string
     */
    private function addToHeaders($string)
    {
        $this->headers .= $string;
    }

    /**
     * Retursn true if the Request method supports a body otherwise false
     * @return boolean
     */
    private function hasRequestBody()
    {
        if (in_array($this->getRequest()->getMethod(), array('POST', 'PUT'))) {
            return true;
        }

        return false;
    }
}
