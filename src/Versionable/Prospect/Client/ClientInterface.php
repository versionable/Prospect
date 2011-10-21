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

interface ClientInterface
{
    /**
     * Sets the Adapter
     * @param AdapterInterface The adapter instance
     */
    public function setAdapter(AdapterInterface $adapter);

    /**
     * Returns the adapter instance
     */
    public function getAdapter();

    /**
     * Sends the request to the server
     * @param RequestInteface $request
     * @param ResponseInterface $response
     */
    public function send(RequestInterface $request, ResponseInterface $response);
}
