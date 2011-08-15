<?php

/*
 * This file is part of the Versionable Prospect package.
 *
 * (c) Stuart Lowes <stuart.lowes@versionable.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Versionable\Prospect\Client;

use Versionable\Prospect\Adapter\AdapterInterface;
use Versionable\Prospect\Request\RequestInterface;
use Versionable\Prospect\Response\ResponseInterface;
use Versionable\Prospect\UserAgent\UserAgentInterface;

class Client implements ClientInterface
{
    /**
     * The adapter

     * @var AdapterInterface
     */
    private $adapter = null;

    /**
     * Constructor
     *
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter = null)
    {
        if (!is_null($adapter)) {
            $this->setAdapter($adapter);
        }
    }

    /**
     * Sets the Adapter to be used
     *
     * @param AdapterInterface $adapter
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Returns the current adapter
     *
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Makes the request to the server
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function send(RequestInterface $request, ResponseInterface $response)
    {
        $response = $this->adapter->call($request, $response);

        return $response;
    }

}