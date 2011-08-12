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

use Versionable\Prospect\Request\RequestInterface;
use Versionable\Prospect\Response\ResponseInterface;
use Versionable\Prospect\Request\StringBuilder;

class Socket extends AdapterAbstract implements AdapterInterface
{
    /**
     * Opens the socket and sends the request to the specified url
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return type ResponseInterface The populated Response object
     */
    public function call(RequestInterface $request, ResponseInterface $response)
    {
        $handle = \fsockopen($request->getUrl()->getHostname(), $request->getPort(), $errno, $errstr, 30);

        if (false === $handle) {
            throw new \RuntimeException('Error connecting to host: ' . $request->getUrl()->getHostname());
        }

        $string = '';

        if ($handle) {
            $builder = new StringBuilder();
            $builder->setRequest($request);
            fputs($handle, $builder->toString());

            while (false === feof($handle)) {
                $string .= fgets($handle, 1024);
            }
        }

        $response->parse($string);

        fclose($handle);

        // Handle 301 redirects
        if ($response->getCode() == 301) {
            $response->getHeaders()->get('Location')->getValue();

            $request->getUrl()->setUrl($response->getHeaders()->get('Location')->getValue());
            $request->setCookies($response->getCookies());

            $class = \get_class($response);

            $response = $this->call($request, new $class());
        }

        return $response;
    }

}
