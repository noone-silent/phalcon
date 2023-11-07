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

namespace Phalcon\Tests\Integration\Mvc\Router;

use IntegrationTester;
use Phalcon\Mvc\Router;

class SetDefaultControllerCest
{
    /**
     * Tests Phalcon\Mvc\Router :: setDefaultController()
     *
     * @author Sid Roberts <https://github.com/SidRoberts>
     * @since  2019-05-22
     */
    public function mvcRouterSetDefaultController(IntegrationTester $I)
    {
        $I->wantToTest('Mvc\Router - setDefaultController()');

        $router = new Router();

        $router->setDefaultController('main');

        $I->assertSame(
            'main',
            $router->getDefaults()['controller']
        );
    }
}
