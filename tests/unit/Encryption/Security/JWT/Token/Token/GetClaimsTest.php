<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Tests\Unit\Encryption\Security\JWT\Token\Token;

use Phalcon\Encryption\Security\JWT\Token\Item;
use Phalcon\Encryption\Security\JWT\Token\Signature;
use Phalcon\Encryption\Security\JWT\Token\Token;
use Phalcon\Tests\AbstractUnitTestCase;

final class GetClaimsTest extends AbstractUnitTestCase
{
    /**
     * Unit Tests Phalcon\Encryption\Security\JWT\Token\Token :: getClaims()
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function testEncryptionSecurityJWTTokenTokenGetClaims(): void
    {
        $headers   = new Item(["typ" => "JWT"], "header-encoded");
        $claims    = new Item(["sub" => "valid-subject"], "claim-encoded");
        $signature = new Signature("signature-hash", "signature-encoded");

        $token = new Token($headers, $claims, $signature);

        $expected = Item::class;
        $actual   = $token->getClaims();
        $this->assertInstanceOf($expected, $actual);

        $expected = "valid-subject";
        $actual   = $token->getClaims()
                          ->get('sub')
        ;
        $this->assertSame($expected, $actual);
    }
}
