<?php

/*
 * This file is part of the Versionable Prospect package.
 *
 * (c) Stuart Lowes <stuart.lowes@versionable.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Versionable\Prospect\Response;

use Versionable\Prospect\Header\Collection as HeaderCollection;
use Versionable\Prospect\Cookie\Collection as CookieCollection;
use Versionable\Prospect\Header\CollectionInterface as HeaderCollectionInterface;
use Versionable\Prospect\Cookie\CollectionInterface as CookieCollectionInterface;
use Versionable\Prospect\Cookie\Cookie;
use Versionable\Prospect\Header\Header;

class Response implements ResponseInterface
{
    /*
     * @var integer HTTP Response code
     */
    private $code = null;

    /**
     * Valid response codes
     * @static
     * @var array
     */
    static public $valid_codes = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
    );

    /**
     *
     * @var string Response body
     */
    private $content = '';

    /**
     *
     * @var \Versionable\Prospect\Header\Collection
     */
    private $headers = null;

    /**
     *
     * @var \Versionable\Prospect\Cookie\Collection
     */
    private $cookies = null;

    public function __construct()
    {
        $this->setHeaders(new HeaderCollection());
        $this->setCookies(new CookieCollection());
    }

    public function parse($responseString)
    {
        $this->parseResponse($responseString);
    }

    public function getStatusCode()
    {
        return $this->code;
    }

    public function setStatusCode($code)
    {
        if (array_key_exists($code, self::$valid_codes)) {
            $this->code = $code;
        } else {
            throw new \InvalidArgumentException('Unknown HTTP code: ' . $code);
        }
    }

    public function getStatusMessage()
    {
        if (null !== $this->getStatusCode())
        {
            return self::$valid_codes[$this->getStatusCode()];
        }

        return null;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setHeaders(HeaderCollectionInterface $headers)
    {
        $this->headers = $headers;
    }

    public function getCookies()
    {
        return $this->cookies;
    }

    public function setCookies(CookieCollectionInterface $cookies)
    {
        $this->cookies = $cookies;
    }

    protected function parseResponse($response)
    {
        list($response_headers, $content) = explode("\r\n\r\n", $response, 2);

        $this->setContent($content);

        $header_lines = explode("\r\n", $response_headers);

        // first line of headers is the HTTP response code
        $http_response_line = array_shift($header_lines);

        if (preg_match('@^HTTP/[0-9]\.[0-9] ([0-9]{3})@', $http_response_line, $matches)) {
            $this->setCode($matches[0]);
        }

        foreach ($header_lines as $line) {
            list($name, $value) = explode(': ', $line);

            if ($name == 'Set-Cookie') {
                $cookie = Cookie::parse($value);
                $this->getCookies()->add($cookie);
            } else {
                $header = Header::parse($name, $value);
                $this->getHeaders()->add($header);
            }
        }
    }
}