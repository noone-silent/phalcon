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

namespace Phalcon\Tests\Unit\Assets\Inline\Js;

use Phalcon\Assets\Inline\Js;
use Phalcon\Tests\AbstractUnitTestCase;
use PHPUnit\Framework\Attributes\Test;

final class GetSetFilterTest extends AbstractUnitTestCase
{
    /**
     * Tests Phalcon\Assets\Inline\Js :: getFilter()/setFilter()
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testAssetsInlineJsGetSetFilter(): void
    {
        $asset  = new Js('<script>alert("Hello");</script>');
        $actual = $asset->getFilter();
        $this->assertTrue($actual);

        $asset->setFilter(false);

        $actual = $asset->getFilter();
        $this->assertFalse($actual);
    }
}
