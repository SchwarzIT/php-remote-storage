<?php

declare(strict_types = 1);

namespace Chapterphp\FileSystem\Model;

use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

class Filename
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function create(string $name): self
    {
        return new self(self::simplify($name));
    }

    public static function createUnique(string $name): self
    {
        return new self(
            sprintf(
                '%s-%s.%s',
                self::simplify($name),
                Uuid::v4()->toBase32(),
                self::getExtension($name)
            )
        );
    }

    /**
     * @read https://stackoverflow.com/questions/5172261/where-and-why-do-we-use-tostring-in-php
     */
    public function toString(): string
    {
        return $this->name;
    }

    private static function simplify(string $name): string
    {
        $basename = pathinfo($name, PATHINFO_FILENAME);

        $asciiString = transliterator_transliterate('Any-Latin; Latin-ASCII', $basename);
        $simplified = preg_replace('/[^A-Za-z0-9_-]/', '_', $asciiString);
        $simplified = preg_replace('/[_]+/', '_', $simplified);

        Assert::notEmpty($name, sprintf('Invalid parameter $name: "%s"', $name));

        return $simplified;
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

    private static function getExtension(string $name): string
    {
        return strtolower(pathinfo($name, PATHINFO_EXTENSION));
    }
}
