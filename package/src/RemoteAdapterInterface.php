<?php

declare(strict_types = 1);

namespace Chapterphp\Storage;

use Chapterphp\Storage\Model\File;
use Chapterphp\Storage\Model\FileMeta;
use Chapterphp\Storage\Model\FileName;

interface RemoteAdapterInterface
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
