<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Tests\Unit\Mvc\Router;

use Phalcon\Tests\Fixtures\Traits\RouterTrait;
use Phalcon\Tests\AbstractUnitTestCase;

final class AddGetTest extends AbstractUnitTestCase
{
    use RouterTrait;

    /**
     * Tests Phalcon\Mvc\Router :: addGet()
     *
     * @author Sid Roberts <https://github.com/SidRoberts>
     * @since  2019-04-17
     */
    public function testMvcRouterAddGet(): void
    {
        $router = $this->getRouter(false);

        $router->addGet(
            '/docs/index',
            [
                'controller' => 'documentation4',
                'action'     => 'index',
            ]
        );


        $_SERVER['REQUEST_METHOD'] = 'GET';

        $router->handle('/docs/index');


        $this->assertSame(
            'documentation4',
            $router->getControllerName()
        );

        $this->assertSame(
            'index',
            $router->getActionName()
        );

        $this->assertSame(
            [],
            $router->getParams()
        );
    }
}
