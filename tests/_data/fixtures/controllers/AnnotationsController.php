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

namespace Phalcon\Tests\Controllers;

use Phalcon\Annotations\Router\Delete;
use Phalcon\Annotations\Router\Patch;
use Phalcon\Annotations\Router\Post;
use Phalcon\Annotations\Router\Put;
use Phalcon\Annotations\Router\Route;
use Phalcon\Annotations\Router\RoutePrefix;

#[RoutePrefix('/annotations')]
class AnnotationsController
{
    #[Route('/', methods: ['GET'])]
    public function indexAction(): void
    {
    }

    #[Route('/view/{id:[0-9]+}', methods: ['GET'])]
    public function viewAction(int $id): void
    {
    }

    #[Delete('/{id:[0-9+]}', converters: ['id' => '\\Phalcon\\Tests\\Controllers\\AnnotationsController::checkId'])]
    public function deleteAction(int $id): void
    {
    }

    #[Post('/{id:[0-9+]}')]
    public function postAction(int $id): void
    {
    }

    #[Put('/{id:[0-9+]}')]
    public function putAction(int $id): void
    {
    }

    #[Patch('/{id:[0-9+]}')]
    public function patchAction(int $id): void
    {
    }

    public static function checkId($id): int
    {
        return (int)$id;
    }
}
