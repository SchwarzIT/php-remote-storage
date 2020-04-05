<?php

declare(strict_types = 1);

namespace Chapterphp\FileSystem;

use Chapterphp\FileSystem\Model\File;
use Chapterphp\FileSystem\Model\FileMeta;
use Chapterphp\FileSystem\Model\FileName;

interface FileSystemInterface
{
    /**
     * @return FileMeta[]
     */
    public function list(): array;

    public function get(FileName $fileName): ?File;

    public function preview(FileName $fileName): string;

    public function delete(FileName $fileName): void;

    public function save(File $file): string;
}
