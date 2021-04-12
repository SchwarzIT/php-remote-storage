<?php

declare(strict_types = 1);

namespace Chapterphp\Storage\Exception;

use Exception;

final class FileStorageException extends Exception
{
    public static function onFailureInFilesystem(string $location): self
    {
        return new Exception(sprintf('Can not read file from "%s"', $location));
    }

    public static function onInvalidFileName(string $fileName): self
    {
        return new Exception(sprintf('The original file name "%s" is invalid', $fileName));
    }
}
