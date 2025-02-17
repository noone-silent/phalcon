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

namespace Phalcon\Tests\Database\Mvc\Model\Criteria;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Tests\AbstractDatabaseTestCase;

final class GetColumnsTest extends AbstractDatabaseTestCase
{
    /**
     * Tests Phalcon\Mvc\Model\Criteria :: getColumns()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-02-01
     *
     * @group mysql
     */
    public function testMvcModelCriteriaGetColumns(): void
    {
        $criteria = new Criteria();
        $criteria
            ->columns('inv_id, inv_cst_id, inv_total')
        ;

        $expected = 'inv_id, inv_cst_id, inv_total';
        $actual   = $criteria->getColumns();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Tests Phalcon\Mvc\Model\Criteria :: getColumns() - array
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-02-01
     *
     * @group mysql
     */
    public function testMvcModelCriteriaGetColumnsArray(): void
    {
        $criteria = new Criteria();
        $criteria
            ->columns(
                [
                    'id'     => 'inv_id',
                    'cst_id' => 'inv_cst_id',
                    'total'  => 'inv_total',
                ]
            )
        ;

        $expected = [
            'id'     => 'inv_id',
            'cst_id' => 'inv_cst_id',
            'total'  => 'inv_total',
        ];
        $actual   = $criteria->getColumns();
        $this->assertEquals($expected, $actual);
    }
}
