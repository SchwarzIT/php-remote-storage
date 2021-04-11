<?php

declare(strict_types = 1);

namespace Chapterphp\FileSystem\Exception;

use Exception;

final class S3AdapterException extends Exception
{
    public static function onListObjects(string $message): void
    {
        throw new self(sprintf('Listing the objects from S3 bucket failed: %s', $message));
    }

    public static function onLoadObject(string $message): void
    {
        throw new self(sprintf('Loading the object from S3 bucket failed: %s', $message));
    }

    public static function onSaveObject(string $message): void
    {
        throw new self(sprintf('Saving the object to S3 bucket failed: %s', $message));
    }

    public static function onDeleteObject(string $message): void
    {
        throw new self(sprintf('Deleting the object from S3 bucket failed: %s', $message));
    }
}
