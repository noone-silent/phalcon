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

namespace Phalcon\Tests\Unit\Support\Debug;

use Phalcon\Support\Debug;
use Phalcon\Tests\AbstractUnitTestCase;
use PHPUnit\Framework\Attributes\Test;

use function sprintf;

/**
 * Class GetCssSourcesTest extends AbstractUnitTestCase
 *
 * @package Phalcon\Tests\Unit\Support\Debug
 */
final class GetCssSourcesTest extends AbstractUnitTestCase
{
    /**
     * Tests Phalcon\Debug :: getCssSources()
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testSupportDebugGetCssSources(): void
    {
        $debug = new Debug();
        $uri   = 'https://assets.phalcon.io/debug/6.0.x/';

        $expected = "
    <link href='{$uri}assets/jquery-ui/themes/ui-lightness/jquery-ui.min.css'
          rel='stylesheet' 
          type='text/css' />
    <link href='{$uri}assets/jquery-ui/themes/ui-lightness/theme.css'
          rel='stylesheet' 
          type='text/css' />
    <link href='{$uri}themes/default/style.css'
          rel='stylesheet' 
          type='text/css' />";

        $actual = $debug->getCssSources();
        $this->assertSame($expected, $actual);
    }
}
