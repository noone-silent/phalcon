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

namespace Phalcon\Tests\Integration\Cache\Adapter;

use Codeception\Example;
use IntegrationTester;
use Memcached as NativeMemcached;
use Phalcon\Cache\Adapter\Apcu;
use Phalcon\Cache\Adapter\Libmemcached;
use Phalcon\Cache\Adapter\Memory;
use Phalcon\Cache\Adapter\Redis;
use Phalcon\Cache\Adapter\Stream;
use Phalcon\Storage\SerializerFactory;
use Redis as NativeRedis;

use function getOptionsLibmemcached;
use function getOptionsRedis;
use function outputDir;
use function sprintf;
use function uniqid;

class GetSetCest
{
    /**
     * Tests Phalcon\Cache\Adapter\* :: get()/set()
     *
     * @dataProvider getExamples
     *
     * @author       Phalcon Team <team@phalcon.io>
     * @since        2020-09-09
     */
    public function storageAdapterGetSetWithZeroTtl(IntegrationTester $I, Example $example)
    {
        $I->wantToTest(
            sprintf(
                'Cache\Adapter\%s - get()/set()',
                $example['className']
            )
        );

        $extension = $example['extension'];
        $class     = $example['class'];
        $options   = $example['options'];

        if (!empty($extension)) {
            $I->checkExtensionIsLoaded($extension);
        }

        $serializer = new SerializerFactory();
        $adapter    = new $class($serializer, $options);

        $key = uniqid();

        $result = $adapter->set($key, "test");
        $I->assertTrue($result);

        $result = $adapter->has($key);
        $I->assertTrue($result);

        /**
         * This will issue delete
         */
        $result = $adapter->set($key, "test", 0);
        $I->assertTrue($result);

        $result = $adapter->has($key);
        $I->assertFalse($result);
    }

    /**
     * @return array[]
     */
    private function getExamples(): array
    {
        return [
            [
                'className' => 'Apcu',
                'class'     => Apcu::class,
                'options'   => [],
                'expected'  => null,
                'extension' => 'apcu',
            ],
            [
                'className' => 'Libmemcached',
                'class'     => Libmemcached::class,
                'options'   => getOptionsLibmemcached(),
                'expected'  => NativeMemcached::class,
                'extension' => 'memcached',
            ],
            [
                'className' => 'Memory',
                'label'     => 'default',
                'class'     => Memory::class,
                'options'   => [],
                'expected'  => null,
                'extension' => '',
            ],
            [
                'className' => 'Redis',
                'label'     => 'default',
                'class'     => Redis::class,
                'options'   => getOptionsRedis(),
                'expected'  => NativeRedis::class,
                'extension' => 'redis',
            ],
            [
                'className' => 'Stream',
                'label'     => 'default',
                'class'     => Stream::class,
                'options'   => [
                    'storageDir' => outputDir(),
                ],
                'expected'  => null,
                'extension' => '',
            ],
        ];
    }
}
