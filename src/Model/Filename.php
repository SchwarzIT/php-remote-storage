<?php

declare(strict_types = 1);

namespace Chapterphp\FileSystem;

use Webmozart\Assert\Assert;

class Filename
{
    private $name;

    public function __construct(string $name)
    {
        Assert::notEmpty($name, 'The parameter $name must not be empty string.');

        $this->name = $name;
    }

    public function create(string $name): self
    {
        return new self($name);
    }

    public function createUnique(string $name): self
    {

    }
}
