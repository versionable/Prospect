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
    /**
     * The file handle the response is written to.
     *
     * @var resource File handle
     */
    private $fileHandle;

    public function __construct()
    {
        parent::__construct();
    }

    public function call(RequestInterface $request, ResponseInterface $response)
    {

        $this->setup($request, $response);
        $this->setHandle(\curl_init());
        $this->initialize($request, $response);

        $this->send($request, $response);

        $info = \curl_getinfo($this->getHandle());
        $response->setCode($info['http_code']);

        return $response;
    }

    protected function setup(RequestInterface $request, ResponseInterface $response)
    {
        parent::setup($request, $response);
        $this->setOption(\CURLOPT_HEADERFUNCTION, array(&$response, 'headerCallback'));
        $this->setOption(\CURLOPT_HEADER, false);
        $this->setOption(\CURLOPT_URL, $request->getUrl()->toString());
        $this->setOption(\CURLOPT_FILE, $response->getFileHandle());
    }
}

