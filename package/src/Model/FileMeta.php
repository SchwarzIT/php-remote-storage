<?php

declare(strict_types = 1);

namespace Chapterphp\FileSystem\Model;

use DateTimeImmutable;

class FileMeta
{
    private $name;
    private $size;
    private $lastModified;
    private $previewUrl = null;

    public function __construct(
        string $name,
        int $size,
        DateTimeImmutable $lastModified
    ) {
        $this->name = $name;
        $this->size = $size;
        $this->lastModified = $lastModified;
    }

    public static function fromS3IteratorResult(array $result): self
    {
        return new self(
            (string) $result['Key'],
            (int) $result['Size'],
            DateTimeImmutable::createFromMutable($result['LastModified'])
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getLastModified(): DateTimeImmutable
    {
        return $this->lastModified;
    }

    public function getPreviewUrl(): ?string
    {
        return $this->previewUrl;
    }

    public function setPreviewUrl(string $previewUrl): self
    {
        $this->previewUrl = $previewUrl;

        return $this;
    }

    public function toString(): string
    {
        return $this->name;
    }
}
