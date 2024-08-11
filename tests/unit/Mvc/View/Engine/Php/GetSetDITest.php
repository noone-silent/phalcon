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

namespace Phalcon\Tests\Unit\Mvc\View\Engine\Php;

use Phalcon\Di\Di;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php;
use Phalcon\Tests\AbstractUnitTestCase;

class GetSetDITest extends AbstractUnitTestCase
{
    /**
     * Tests Phalcon\Mvc\View\Engine\Php :: getDI() / setDI()
     *
     * @author Sid Roberts <https://github.com/SidRoberts>
     * @since  2019-05-22
     */
    public function testMvcViewEnginePhpGetSetDI(): void
    {
        $view = new View();

        $di1 = new Di();
        $di2 = new Di();

        $engine = new Php($view, $di1);

        $this->assertSame(
            $di1,
            $engine->getDI()
        );

        $engine->setDI($di2);

        $this->assertSame(
            $di2,
            $engine->getDI()
        );
    }
}
