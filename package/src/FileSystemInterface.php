<?php

declare(strict_types = 1);

namespace Chapterphp\FileSystem;

use Chapterphp\FileSystem\Model\File;
use Chapterphp\FileSystem\Model\FileName;

interface FileSystemInterface
{
    public function get(FileName $fileName): ?File;

    public function delete(FileName $fileName): void;

    public function save(File $file): string;
}
