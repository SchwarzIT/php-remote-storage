<?php

declare(strict_types = 1);

namespace Chapterphp\Tests\Model;

use Chapterphp\FileSystem\Model\Filename;
use PHPUnit\Framework\TestCase;

class FilenameTest extends TestCase
{
    public function testCreate()
    {
        $filename = Filename::create('foo.pdf');

        $this->assertEquals('foo', $filename->getBase());
        $this->assertEquals('pdf', $filename->getExtension());
        $this->assertEquals('foo.pdf', $filename->toString());

    }

    public function testCreateUnique()
    {
        $amount = 10;
        $results = [];

        for ($i = 1; $i <= $amount; $i++) {
            $filename = Filename::createUnique('foo.pdf');
            $results[$filename->getBase()] = $filename;
        }

        $this->assertCount($amount, $results);
    }
}
