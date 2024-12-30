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

namespace Phalcon\Tests\Unit\Assets\Asset;

use Phalcon\Assets\Asset;
use Phalcon\Tests\Fixtures\Traits\AssetsTrait;
use Phalcon\Tests\AbstractUnitTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class ConstructTest extends AbstractUnitTestCase
{
    use AssetsTrait;

    /**
     * Tests Phalcon\Assets\Asset :: __construct() - attributes
     *
     * @dataProvider providerAssets
     *
     * @return void
     *
     * @author       Phalcon Team <team@phalcon.io>
     * @since        2020-09-09
     */
    #[DataProvider('providerAssets')]
    public function testAssetsAssetConstructAttributes(
        string $type,
        string $path
    ): void {
        $asset = new Asset($type, $path);

        $expected = [];
        $actual   = $asset->getAttributes();
        $this->assertSame($expected, $actual);
    }

    /**
     * Tests Phalcon\Assets\Asset :: __construct() - attributes set
     *
     * @dataProvider providerAssets
     *
     * @return void
     *
     * @author       Phalcon Team <team@phalcon.io>
     * @since        2020-09-09
     */
    #[DataProvider('providerAssets')]
    public function testAssetsAssetConstructAttributesSet(
        string $type,
        string $path
    ): void {
        $attributes = [
            'data' => 'phalcon',
        ];

        $asset = new Asset(
            $type,
            $path,
            true,
            true,
            $attributes
        );

        $actual = $asset->getAttributes();
        $this->assertSame($attributes, $actual);
    }

    /**
     * Tests Phalcon\Assets\Asset :: __construct() - filter
     *
     * @dataProvider providerAssets
     *
     * @return void
     *
     * @author       Phalcon Team <team@phalcon.io>
     * @since        2020-09-09
     */
    #[DataProvider('providerAssets')]
    public function testAssetsAssetConstructFilter(
        string $type,
        string $path
    ): void {
        $asset = new Asset($type, $path);

        $actual = $asset->getFilter();
        $this->assertTrue($actual);
    }

    /**
     * Tests Phalcon\Assets\Asset :: __construct() - filter set
     *
     * @dataProvider providerAssets
     *
     * @return void
     *
     * @author       Phalcon Team <team@phalcon.io>
     * @since        2020-09-09
     */
    #[DataProvider('providerAssets')]
    public function testAssetsAssetConstructFilterSet(
        string $type,
        string $path
    ): void {
        $asset = new Asset(
            $type,
            $path,
            true,
            false
        );

        $actual = $asset->getFilter();
        $this->assertFalse($actual);
    }

    /**
     * Tests Phalcon\Assets\Asset :: __construct() - local
     *
     * @dataProvider providerAssets
     *
     *
     * @return void
     * @author       Phalcon Team <team@phalcon.io>
     * @since        2020-09-09
     */
    #[DataProvider('providerAssets')]
    public function testAssetsAssetConstructLocal(
        string $type,
        string $path
    ): void {
        $asset  = new Asset($type, $path);
        $actual = $asset->isLocal();
        $this->assertTrue($actual);
    }

    /**
     * Tests Phalcon\Assets\Asset :: __construct() - remote
     *
     * @dataProvider providerAssets
     *
     * @return void
     *
     * @author       Phalcon Team <team@phalcon.io>
     * @since        2020-09-09
     */
    #[DataProvider('providerAssets')]
    public function testAssetsAssetConstructRemote(
        string $type,
        string $path
    ): void {
        $asset  = new Asset($type, $path, false);
        $actual = $asset->isLocal();
        $this->assertFalse($actual);
    }
}
