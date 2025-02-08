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

namespace Phalcon\Tests\Unit\Filter\Validation\Validator\File;

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File;
use Phalcon\Tests\AbstractUnitTestCase;
use Phalcon\Tests\Fixtures\Filter\Validation\Validator\File\MimeTypeFixture;
use PHPUnit\Framework\Attributes\BackupGlobals;
use PHPUnit\Framework\Attributes\Test;

#[BackupGlobals(true)]
final class MimeTest extends AbstractUnitTestCase
{
    /**
     * Tests Phalcon\Filter\Validation\Validator\File :: validate()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2018-11-13
     */
    public function testFilterValidationValidatorFileMimeTypeNotUploaded(): void
    {
        $_SERVER = [
            'REQUEST_METHOD' => 'POST',
        ];

        $_FILES = [
            'thumbnail' => [
                'name'      => 'IMG-20180403-WA0000.jpg',
                'full_path' => 'IMG-20180403-WA0000.jpg',
                'type'      => 'image/jpeg',
                'tmp_name'  => '/tmp/phpsjLIQJ',
                'error'     => 0,
                'size'      => 11768,
            ],
        ];

        $options = [
            'types'   => ['image/jpeg', 'image/png'],
            'message' => 'Allowed file types are :types'
        ];
        $validator = new File\MimeType($options);
        $validation = new Validation();
        $validation->add('thumbnail', $validator);

        $messages = $validation->validate($_FILES);
        $this->assertCount(1, $messages);
    }

    /**
     * Tests Phalcon\Filter\Validation\Validator\File :: validate()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2018-11-13
     */
    public function testFilterValidationValidatorFileMimeTypeWrongTypes(): void
    {
        $_SERVER = [
            'REQUEST_METHOD' => 'POST',
        ];

        $_FILES = [
            'thumbnail' => [
                'name'      => 'IMG-20180403-WA0000.jpg',
                'full_path' => 'IMG-20180403-WA0000.jpg',
                'type'      => 'image/jpeg',
                'tmp_name'  => '/tmp/phpsjLIQJ',
                'error'     => 0,
                'size'      => 11768,
            ],
        ];

        $options = [
            'types'   => ['image/gif'],
            'message' => 'Allowed file types are :types'
        ];
        $validator = new MimeTypeFixture($options);
        $validation = new Validation();
        $validation->add('thumbnail', $validator);

        $messages = $validation->validate($_FILES);
        $this->assertCount(1, $messages);

        $expected = 'Allowed file types are image/gif';
        $actual   = $messages[0]->getMessage();
        $this->assertSame($expected, $actual);
    }

    /**
     * Tests Phalcon\Filter\Validation\Validator\File :: validate()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2018-11-13
     */
    public function testFilterValidationValidatorFileMimeType(): void
    {
        $_SERVER = [
            'REQUEST_METHOD' => 'POST',
        ];

        $_FILES = [
            'thumbnail' => [
                'name'      => 'IMG-20180403-WA0000.jpg',
                'full_path' => 'IMG-20180403-WA0000.jpg',
                'type'      => 'image/jpeg',
                'tmp_name'  => '/tmp/phpsjLIQJ',
                'error'     => 0,
                'size'      => 11768,
            ],
        ];

        $options = [
            'types'   => ['image/jpeg', 'image/png'],
            'message' => 'Allowed file types are :types'
        ];
        $validator = new MimeTypeFixture($options);
        $validation = new Validation();
        $validation->add('thumbnail', $validator);

        $messages = $validation->validate($_FILES);
        $this->assertCount(0, $messages);
    }

    /**
     * Tests Phalcon\Filter\Validation\Validator\File :: validate()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2018-11-13
     */
    public function testFilterValidationValidatorFileMimeTypeException(): void
    {
        $_SERVER = [
            'REQUEST_METHOD' => 'POST',
        ];

        $_FILES = [
            'thumbnail' => [
                'name'      => 'IMG-20180403-WA0000.jpg',
                'full_path' => 'IMG-20180403-WA0000.jpg',
                'type'      => 'image/jpeg',
                'tmp_name'  => '/tmp/phpsjLIQJ',
                'error'     => 0,
                'size'      => 11768,
            ],
        ];

        $options = [
            'message' => 'Allowed file types are :types'
        ];
        $validator = new MimeTypeFixture($options);
        $validation = new Validation();
        $validation->add('thumbnail', $validator);

        $this->expectException(Validation\Exception::class);
        $this->expectExceptionMessage('Option \'types\' must be an array');
        $validation->validate($_FILES);
    }

    /**
     * Tests Phalcon\Filter\Validation\Validator\File :: customMessages[]
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2018-11-13
     */
    public function testFilterValidationValidatorFileValidateAllowedTypes(): void
    {
        $options    = [
            'allowedTypes'     => ['image/png'],
            'messageValid'     => 'File is not valid',
        ];
        $file       = new File($options);
        $validators = $file->getValidators();

        $this->assertCount(1, $validators);

        $expected  = File\MimeType::class;
        $actual    = $validators[0];
        $this->assertInstanceOf($expected, $actual);
    }
}
