<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.txt file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Tests\Database\Mvc\Model\Manager;

use Phalcon\Mvc\Model\ManagerInterface;
use Phalcon\Mvc\Model\Query\StatusInterface;
use Phalcon\Mvc\Model\Resultset\Complex;
use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Storage\Exception;
use Phalcon\Tests\AbstractDatabaseTestCase;
use Phalcon\Tests\Fixtures\Traits\DiTrait;
use Phalcon\Tests\Models\Invoices;

final class ExecuteQueryTest extends AbstractDatabaseTestCase
{
    use DiTrait;

    /**
     * Executed before each test
     *
     * @return void
     */
    public function setUp(): void
    {
        try {
            $this->setNewFactoryDefault();
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->setDatabase();
    }

    /**
     * Tests Phalcon\Mvc\Model\Manager :: executeQuery() - Issue 15024
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-05-06
     * @issue  15024
     *
     * @group mysql
     * @group pgsql
     */
    public function testMvcModelManagerExecuteQuery(): void
    {
        /** @var ManagerInterface $manager */
        $manager = $this->getService('modelsManager');

        $sql = sprintf('SELECT * FROM [%s]', Invoices::class);
        $this->assertInstanceOf(Simple::class, $manager->executeQuery($sql));

        $sql = sprintf('SELECT SUM(inv_total) AS s FROM [%s]', Invoices::class);
        $this->assertInstanceOf(Simple::class, $manager->executeQuery($sql));

        $sql = sprintf('SELECT i.inv_total FROM [%s] AS i WHERE i.inv_id = :id:', Invoices::class);
        $this->assertInstanceOf(Simple::class, $manager->executeQuery($sql, ['id' => 0]));

        $sql = sprintf('SELECT COUNT(inv_status_flag) FROM [%s] GROUP BY inv_status_flag', Invoices::class);
        $this->assertInstanceOf(Complex::class, $manager->executeQuery($sql));

        $sql = sprintf('INSERT INTO [%s] (inv_total) VALUES (1)', Invoices::class);
        $this->assertInstanceOf(StatusInterface::class, $manager->executeQuery($sql));

        $sql = sprintf('UPDATE [%s] SET inv_total = 0 WHERE inv_id = :id:', Invoices::class);
        $this->assertInstanceOf(StatusInterface::class, $manager->executeQuery($sql, ['id' => 0]));

        $sql = sprintf('DELETE FROM [%s] WHERE inv_id = :id:', Invoices::class);
        $this->assertInstanceOf(StatusInterface::class, $manager->executeQuery($sql, ['id' => 0]));
    }
}
