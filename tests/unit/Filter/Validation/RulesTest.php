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

namespace Phalcon\Tests\Unit\Filter\Validation;

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Alpha;
use Phalcon\Filter\Validation\Validator\Email;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Tests\AbstractUnitTestCase;
use PHPUnit\Framework\Attributes\Test;

final class RulesTest extends AbstractUnitTestCase
{
    /**
     * Tests Phalcon\Filter\Validation :: rules()
     *
     * @author Sid Roberts <https://github.com/SidRoberts>
     * @since  2019-05-27
     */
    public function testFilterValidationRules(): void
    {
        $alpha      = new Alpha();
        $presenceOf = new PresenceOf();
        $email      = new Email();

        $validation = new Validation();

        $validation
            ->rules(
                'name',
                [
                    $alpha,
                    $presenceOf,
                ]
            )
            ->rules(
                'email',
                [
                    $email,
                ]
            )
        ;

        $expected = [
            'name'  => [
                $alpha,
                $presenceOf,
            ],
            'email' => [
                $email,
            ],
        ];
        $actual = $validation->getValidators();
        $this->assertSame($expected, $actual);
    }
}
