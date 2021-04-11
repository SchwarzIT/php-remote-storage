<?php

declare(strict_types = 1);

namespace Chapterphp\Storage;

use Chapterphp\Storage\Model\FileName;

interface FileInterface
{
    public function getFileName(): FileName;

    public function getFileMimeType(): ?string;

    public function getFileContent(): ?string;

    public function getFileLocation(): ?string;

    public function delete(): bool;
}
