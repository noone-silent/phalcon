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

namespace Phalcon\Tests\Database\Mvc\Model;

use Phalcon\Tests\AbstractDatabaseTestCase;
use Phalcon\Tests\Fixtures\Traits\DiTrait;
use Phalcon\Tests\Models\Invoices;

final class GetReadConnectionTest extends AbstractDatabaseTestCase
{
    use DiTrait;

    public function setUp(): void
    {
        $this->setNewFactoryDefault();
        $this->setDatabase();
    }

    /**
     * Tests Phalcon\Mvc\Model :: getReadConnection()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-01-31
     *
     * @group mysql
     */
    public function testMvcModelGetReadConnection(): void
    {
        $connection = $this->container->get('db');
        $invoice    = new Invoices();

        $this->assertEquals($connection, $invoice->getReadConnection());
    }
}
