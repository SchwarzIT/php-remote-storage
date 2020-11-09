<?php

declare(strict_types = 1);

namespace Chapterphp\Tests\Model;

use Chapterphp\FileSystem\Model\Filename;
use PHPUnit\Framework\TestCase;

class FilenameTest extends TestCase
{
    public function testCreate(): void
    {
        $filename = Filename::create('foo.pdf');

        $this->assertEquals('foo', $filename->getBase());
        $this->assertEquals('pdf', $filename->getExtension());
        $this->assertEquals('foo.pdf', $filename->toString());
    }

    public function testCreateUnique(): void
    {
        $amount = 10;
        $results = [];

        for ($i = 1; $i <= $amount; ++$i) {
            $filename = Filename::createUnique('foo.pdf');
            $results[$filename->getBase()] = $filename;
        }

        $this->assertCount($amount, $results);
    }

    /**
     * @dataProvider getTestDataToBeSimplified
     */
    public function testBaseNameAreSimplified(string $original, string $expected): void
    {
        $filename = Filename::create($original);

        $this->assertEquals($expected, $filename->toString());
    }

    public function getTestDataToBeSimplified(): array
    {
        return [
            ['foo.txt', 'foo.txt'],
            ['fooÜ.txt', 'fooU.txt'],
            ['fooÄ.txt', 'fooA.txt'],
            ['fooÖ.txt', 'fooO.txt'],
            ['fooß.txt', 'fooss.txt'],
            ['foo$.txt', 'foo_.txt'],
            ['foo?.txt', 'foo_.txt'],
            ['foo%.txt', 'foo_.txt'],
            ['foo&.txt', 'foo_.txt'],
            ['(foo).txt', '_foo_.txt'],
        ];
    }
}
