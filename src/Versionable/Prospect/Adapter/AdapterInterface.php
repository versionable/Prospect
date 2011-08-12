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

interface AdapterInterface
{
    /*
     * @param Versionable\Prospect\RequestRequestInterface $request
     * @param Versionable\Prospect\Response\ResponseInterface $response
     *
     * @return Versionable\Prospect\Response\ResponseInterface
     */

    public function call(RequestInterface $request, ResponseInterface $response);

    public function setOption($name, $value);

    public function getOption($name);
}
