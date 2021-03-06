<?php

declare(strict_types = 1);

namespace Chapterphp\Tests;

use Aws\S3\S3Client;
use Chapterphp\Storage\Model\File;
use Chapterphp\Storage\Model\FileName;
use Chapterphp\Storage\S3Adapter;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

class S3AdapterTest extends TestCase
{
    private const TEST_S3_BUCKET = 'test';
    private const TEST_S3_ENDPOINT = 'http://localhost:9001';

    public function testS3Adapter(): void
    {
        $testFileName = FileName::create('sit.png');

        // 01: test saving the test file on s3
        $fileSystem = new S3Adapter($this->createTestClient(), self::TEST_S3_BUCKET);

        $pngFile = File::createFromFileInfo(new SplFileInfo(__DIR__ . '/' . $testFileName->toString()));
        $savedFileName = $fileSystem->save($pngFile);

        $this->assertEquals($testFileName->toString(), $savedFileName);

        // 02: test loading the uploaded file
        $loadedFile = $fileSystem->get($testFileName);
        $this->assertEquals($testFileName->toString(), $loadedFile->getFileName()->toString());

        // 03: test deleting the uploading file
        $fileSystem->delete($testFileName);
    }

    private function createTestClient(): S3Client
    {
        return new S3Client(
            [
                'profile' => 'default',
                'region' => 'us-west-2',
                'version' => '2006-03-01',
                'endpoint' => self::TEST_S3_ENDPOINT,
                'use_path_style_endpoint' => true,
            ]
        );
    }
}
