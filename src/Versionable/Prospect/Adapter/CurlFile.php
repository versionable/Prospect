<?php

namespace Versionable\Prospect\Adapter;

use Versionable\Prospect\Request\RequestInterface;
use Versionable\Prospect\Response\ResponseInterface;

class CurlFile extends Curl
{
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

        return $response;
    }

    protected function setup(RequestInterface $request, ResponseInterface $response)
    {
        parent::setup($request, $response);
        $this->setOption(\CURLOPT_HEADERFUNCTION, array($response, 'headerCallback'));
        $this->setOption(\CURLOPT_HEADER, false);
        $this->setOption(\CURLOPT_URL, $request->getUrl()->toString());
        $this->setOption(\CURLOPT_FILE, $response->getFileHandle());
    }
}

