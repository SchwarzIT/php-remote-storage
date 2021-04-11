<?php

declare(strict_types = 1);

namespace Chapterphp\Tests\Exception;

use Chapterphp\Storage\Exception\S3AdapterException;
use Exception;
use PHPUnit\Framework\TestCase;

class S3AdapterExceptionTest extends TestCase
{
    public function testExceptionOnLoadObject(): void
    {
        $this->expectException(S3AdapterException::class);

        $exception = new Exception('onLoad');
        S3AdapterException::onLoadObject($exception->getMessage());
    }

    public function testExceptionOnDelete(): void
    {
        $this->expectException(S3AdapterException::class);

        $exception = new Exception('onDelete');
        S3AdapterException::onDeleteObject($exception->getMessage());
    }

    public function testExceptionOnPut(): void
    {
        $this->expectException(S3AdapterException::class);

        $exception = new Exception('onSave');
        S3AdapterException::onSaveObject($exception->getMessage());
    }
}
