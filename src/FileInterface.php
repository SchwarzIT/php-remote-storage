<?php

declare(strict_types = 1);

namespace Chapterphp\FileSystem;

use Chapterphp\FileSystem\Model\FileName;

interface FileInterface
{
    public function getFilename(): FileName;
    public function getMimeType(): ?string;
    public function getContent(): ?string;
    public function getFileLocation(): ?string;
    public function delete(): void;
}
