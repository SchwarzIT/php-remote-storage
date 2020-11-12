<?php

declare(strict_types = 1);

namespace Chapterphp\FileSystem\S3FileSystem;

use Aws\S3\S3Client;
use Chapterphp\FileSystem\Exception\S3FileSystemException;
use Chapterphp\FileSystem\FileSystemInterface;
use Chapterphp\FileSystem\Model\File;
use Chapterphp\FileSystem\Model\FileName;
use Throwable;

final class S3FileSystem implements FileSystemInterface
{
    // S3 related keys are capitalized
    private const KEY_S3_BODY = 'Body';
    private const KEY_S3_BUCKET = 'Bucket';
    private const KEY_S3_KEY = 'Key';

    private $s3Client;
    private $s3Bucket;

    public function __construct(S3Client $s3Client, string $s3Bucket)
    {
        $this->s3Client = $s3Client;
        $this->s3Bucket = $s3Bucket;
    }

    public function get(FileName $fileName): ?File
    {
        $body = null;

        try {
            $result = $this->s3Client->getObject($this->getRequestObjectConfig($fileName));
            $body = $result->get(self::KEY_S3_BODY);
        } catch (Throwable $exception) {
            S3FileSystemException::onLoadObject($exception->getMessage());
        }

        return $body === null ? null : File::createTempFile($fileName, (string) $body);
    }

    public function delete(FileName $fileName): void
    {
        try {
            $this->s3Client->deleteObject($this->getRequestObjectConfig($fileName));
        } catch (Throwable $exception) {
            S3FileSystemException::onDeleteObject($exception->getMessage());
        }
    }

    public function save(File $file): string
    {
        $config = $this->getRequestObjectConfig($file->getFileName());
        $config[self::KEY_S3_BODY] = $file->getFileContent();

        try {
            $this->s3Client->putObject($config);
        } catch (Throwable $exception) {
            S3FileSystemException::onSaveObject($exception->getMessage());
        }
    }

    private function getRequestObjectConfig(FileName $fileName): array
    {
        return [
            self::KEY_S3_BUCKET => $this->s3Bucket,
            self::KEY_S3_KEY => $fileName->toString(),
        ];
    }
}
