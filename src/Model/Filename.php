<?php

declare(strict_types = 1);

namespace Chapterphp\FileSystem\Model;

use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

class Filename
{
    private $base;
    private $extension;

    public function __construct(string $base, string $extension)
    {
        $this->base = $base;
        $this->extension = $extension;
    }

    public static function create(string $name): self
    {
        [$base, $extension] = self::resolveFileSegments(self::simplify($name));

        return new self($base, $extension);
    }

    public static function createUnique(string $name): self
    {
        [$base, $extension] = self::resolveFileSegments(self::simplify($name));

        return new self(
            sprintf(
                '%s-%s',
                $base,
                Uuid::v4()->toBase32()
            ),
            $extension
        );
    }

    public function getBase(): string
    {
        return $this->base;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @read https://stackoverflow.com/questions/5172261/where-and-why-do-we-use-tostring-in-php
     */
    public function toString(): string
    {
        return sprintf('%s.%s', $this->base, $this->extension);
    }

    private static function simplify(string $name): string
    {
        $base = pathinfo($name, PATHINFO_FILENAME);
        $extension = pathinfo($name, PATHINFO_EXTENSION);

        $asciiString = transliterator_transliterate('Any-Latin; Latin-ASCII', $base);
        $simplified = preg_replace('/[^A-Za-z0-9_-]/', '_', $asciiString);
        $simplified = preg_replace('/[_]+/', '_', $simplified);

        return sprintf('%s.%s', $simplified, $extension);
    }

    /**
     * @return string[]
     */
    private static function resolveFileSegments(string $name): array
    {
        $base = pathinfo($name, PATHINFO_FILENAME);
        $extension = pathinfo($name, PATHINFO_EXTENSION);

        Assert::notEmpty($base, sprintf('Invalid base name: "%s"', $base));
        Assert::notEmpty($extension, sprintf('Invalid extension name: "%s"', $extension));

        return [$base, $extension];
    }
}
