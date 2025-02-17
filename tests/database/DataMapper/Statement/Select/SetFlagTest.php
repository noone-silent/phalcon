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

namespace Phalcon\Tests\Database\DataMapper\Statement\Select;

use Phalcon\DataMapper\Statement\Select;
use Phalcon\Tests\AbstractStatementTestCase;

use function env;

final class SetFlagTest extends AbstractStatementTestCase
{
    /**
     * Database Tests Phalcon\DataMapper\Statement\Select :: setFlag()
     *
     * @since  2020-01-20
     *
     * @group mysql
     */
    public function testDmStatementSelectSetFlag(): void
    {
        $driver = env('driver');
        $select = Select::new($driver);

        $select
            ->from('co_invoices')
            ->setFlag('LOW_PRIORITY')
        ;

        $expected = 'SELECT LOW_PRIORITY * FROM co_invoices';
        $actual   = $select->getStatement();
        $this->assertSame($expected, $actual);
    }
}
