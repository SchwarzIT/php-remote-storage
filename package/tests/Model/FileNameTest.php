<?php

declare(strict_types = 1);

namespace Chapterphp\Tests\Model;

use Chapterphp\Storage\Model\FileName;
use PHPUnit\Framework\TestCase;

class FileNameTest extends TestCase
{
    public function testCreate(): void
    {
        $fileName = FileName::create('foo.pdf');

        $this->assertEquals('foo', $fileName->getBase());
        $this->assertEquals('pdf', $fileName->getExtension());
        $this->assertEquals('foo.pdf', $fileName->toString());
    }

    public function testCreateUnique(): void
    {
        $amount = 10;
        $results = [];

        for ($i = 1; $i <= $amount; ++$i) {
            $fileName = FileName::createUnique('foo.pdf');
            $results[$fileName->getBase()] = $fileName;
        }

        $this->assertCount($amount, $results);
    }

    /**
     * @dataProvider getTestDataToBeSimplified
     */
    public function testBaseNameAreSimplified(string $original, string $expected): void
    {
        $fileName = FileName::create($original);

        $this->assertEquals($expected, $fileName->toString());
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
