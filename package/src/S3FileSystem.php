<?php

declare(strict_types = 1);

namespace Chapterphp\FileSystem;

use Aws\Command;
use Aws\ResultPaginator;
use Aws\S3\S3Client;
use Chapterphp\FileSystem\Exception\S3FileSystemException;
use Chapterphp\FileSystem\Model\File;
use Chapterphp\FileSystem\Model\FileName;
use Chapterphp\FileSystem\Model\FileMeta;
use Throwable;

final class S3FileSystem implements FileSystemInterface
{
    // S3 related keys are capitalized
    private const KEY_S3_BODY = 'Body';
    private const KEY_S3_BUCKET = 'Bucket';
    private const KEY_S3_LIST = 'ListObjects';
    private const KEY_S3_RESULT_CONTENTS = 'Contents';
    private const KEY_S3_OBJECT_KEY = 'Key';

    private $s3Client;
    private $s3Bucket;

    public function __construct(S3Client $s3Client, string $s3Bucket)
    {
        $this->s3Client = $s3Client;
        $this->s3Bucket = $s3Bucket;
    }

    /**
     * @return FileName[]
     *
     * @throws S3FileSystemException
     */
    public function list(): array
    {
        $fileNames = [];
        try {
            $paginator = $this->s3Client->getPaginator(self::KEY_S3_LIST, $this->getPaginatorConfig());

            $fileNames = $this->iteratePaginator($paginator);
        } catch (\Exception $exception) {
            S3FileSystemException::onListObjects($exception->getMessage());
        }

        return $fileNames;
    }

    /**
     * @throws S3FileSystemException
     */
    public function get(FileName $fileName): ?File
    {
        $body = null;

        try {
            $result = $this->s3Client->getObject($this->getObjectConfig($fileName));
            $body = $result->get(self::KEY_S3_BODY);
        } catch (Throwable $exception) {
            S3FileSystemException::onLoadObject($exception->getMessage());
        }

        return $body === null ? null : File::createTempFile($fileName, (string) $body);
    }

    /**
     * @throws S3FileSystemException
     */
    public function preview(FileName $fileName): string
    {
        try {
            $request = $this->s3Client->createPresignedRequest($this->getObjectCommand($fileName), '+20 minutes');

            return (string) $request->getUri();
        } catch (Throwable $exception) {
            S3FileSystemException::onLoadObject($exception->getMessage());
        }
    }

    /**
     * @throws S3FileSystemException
     */
    public function delete(FileName $fileName): void
    {
        try {
            $this->s3Client->deleteObject($this->getObjectConfig($fileName));
        } catch (Throwable $exception) {
            S3FileSystemException::onDeleteObject($exception->getMessage());
        }
    }

    /**
     * @throws S3FileSystemException
     */
    public function save(File $file): string
    {
        $config = $this->getObjectConfig($file->getFileName());
        $config[self::KEY_S3_BODY] = $file->getFileContent();

        try {
            $this->s3Client->putObject($config);
        } catch (Throwable $exception) {
            S3FileSystemException::onSaveObject($exception->getMessage());
        }

        return $file->getFileName()->toString();
    }

    private function getObjectCommand(FileName $fileName): Command
    {
        return $this->s3Client->getCommand(
            'GetObject',
            $this->getObjectConfig($fileName)
        );
    }

    /**
     * @return string[]
     */
    private function getObjectConfig(FileName $fileName): array
    {
        return [
            self::KEY_S3_BUCKET => $this->s3Bucket,
            self::KEY_S3_OBJECT_KEY => $fileName->toString(),
        ];
    }

    /**
     * @return string[]
     */
    private function getPaginatorConfig(): array
    {
        return [
            self::KEY_S3_BUCKET => $this->s3Bucket,
        ];
    }

    /**
     * @return FileMeta[]
     */
    private function iteratePaginator(ResultPaginator $paginator): array
    {
        if (!$this->hasResult($paginator)) {
            return [];
        }

        $fileMetaList = [];
        foreach ($paginator as $result) {
            foreach ($result[self::KEY_S3_RESULT_CONTENTS] as $object) {
                $fileMetaList[] = FileMeta::fromS3IteratorResult($object);
            }
        }

        return $fileMetaList;
    }

    private function hasResult(ResultPaginator $paginator): bool
    {
        return $paginator->current()->hasKey(self::KEY_S3_RESULT_CONTENTS);
    }
}
