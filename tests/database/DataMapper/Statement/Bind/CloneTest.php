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

namespace Phalcon\Tests\Database\DataMapper\Statement\Bind;

use PDO;
use Phalcon\DataMapper\Statement\Bind;
use Phalcon\Tests\AbstractDatabaseTestCase;
use ReflectionClass;

final class CloneTest extends AbstractDatabaseTestCase
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        /**
         * This is here to ensure that the tests run fine either individually
         * or as a suite, since the static instance count will increase
         * differently depending on how the test is run (suite/on its own)
         */
        parent::setUp();

        $bind = new ReflectionClass(Bind::class);
        $property = $bind->getProperty('instanceCount');
        $property->setAccessible(true);
        $property->setValue(0);
    }

    /**
     * Database Tests Phalcon\DataMapper\Statement\Bind :: clone()
     *
     * @since  2020-01-20
     *
     * @group  common
     */
    public function testDmQueryBindClone(): void
    {
        $bind = new Bind();

        $expected = [];
        $actual   = $bind->toArray();
        $this->assertSame($expected, $actual);

        $bind->inline("one");
        $bind->inline(true, PDO::PARAM_BOOL);

        $expected = [
            "_1_1_" => ["one", 2],
            "_1_2_" => [true, 5],
        ];
        $actual   = $bind->toArray();
        $this->assertSame($expected, $actual);

        $clone = clone $bind;

        $clone->inline("two");

        $expected = [
            "_1_1_" => ["one", 2],
            "_1_2_" => [true, 5],
            "_2_3_" => ["two", 2],
        ];
        $actual   = $clone->toArray();
        $this->assertSame($expected, $actual);
    }
}
