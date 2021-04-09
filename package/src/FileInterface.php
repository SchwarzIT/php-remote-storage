<?php

declare(strict_types = 1);

namespace Chapterphp\FileSystem;

use Chapterphp\FileSystem\Model\FileName;

interface FileInterface
{
    public function getFileName(): FileName;

    public function getFileMimeType(): ?string;

    public function getFileContent(): ?string;

    public function getFileLocation(): ?string;

    /**
     * return TRUE, only if the file is deleted with success
     */
    public function delete(): bool;
}