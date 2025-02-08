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

final class GetJsSourcesTest extends AbstractUnitTestCase
{
    /**
     * Tests Phalcon\Debug :: getJsSources()
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testSupportDebugGetJsSources(): void
    {
        $debug = new Debug();
        $uri   = 'https://assets.phalcon.io/debug/6.0.x/';

        $expected = "
    <script type='application/javascript' 
            src='{$uri}assets/jquery/dist/jquery.min.js'></script>
    <script type='application/javascript' 
            src='{$uri}assets/jquery-ui/jquery-ui.min.js'></script>
    <script type='application/javascript' 
            src='{$uri}assets/jquery.scrollTo/jquery.scrollTo.min.js'></script>
    <script type='application/javascript' 
            src='{$uri}prettify/prettify.js'></script>
    <script type='application/javascript' 
            src='{$uri}pretty.js'></script>";

        $actual = $debug->getJsSources();
        $this->assertSame($expected, $actual);
    }
}
