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

use Phalcon\Tests\AbstractUnitTestCase;
use PHPUnit\Framework\Attributes\Test;

final class OnUncaughtLowSeverityTest extends AbstractUnitTestCase
{
    /**
     * Tests Phalcon\Debug :: onUncaughtLowSeverity()
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testSupportDebugOnUncaughtLowSeverity(): void
    {
        $this->markTestSkipped('Need implementation');
    }
}
