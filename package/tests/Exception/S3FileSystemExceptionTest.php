<?php

declare(strict_types = 1);

namespace Chapterphp\Tests\Exception;

use Chapterphp\FileSystem\Exception\S3FileSystemException;
use Exception;
use PHPUnit\Framework\TestCase;

class S3FileSystemExceptionTest extends TestCase
{
    public function testExceptionOnLoadObject(): void
    {
        $this->expectException(S3FileSystemException::class);

        $exception = new Exception('onLoad');
        S3FileSystemException::onLoadObject($exception->getMessage());
    }

    public function testExceptionOnDelete(): void
    {
        $this->expectException(S3FileSystemException::class);

        $exception = new Exception('onDelete');
        S3FileSystemException::onDeleteObject($exception->getMessage());
    }

    public function testExceptionOnPut(): void
    {
        $this->expectException(S3FileSystemException::class);

        $exception = new Exception('onSave');
        S3FileSystemException::onSaveObject($exception->getMessage());
    }
}
