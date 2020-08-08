<?php

namespace App\Controller;

use Chapterphp\FileSystem\FileSystemInterface;
use Chapterphp\FileSystem\Model\FileMeta;
use Chapterphp\FileSystem\Model\FileName;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $s3FileSystem;

    public function __construct(FileSystemInterface $s3FileSystem)
    {
        $this->s3FileSystem = $s3FileSystem;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $fileMetaList = $this->s3FileSystem->list();

        return $this->render(
            'home/index.html.twig',
            [
                'items' => $this->resolvePreviewUrl($fileMetaList),
            ]
        );
    }

    /**
     * @param FileMeta[] $fileMetaList
     *
     * @return FileMeta[]
     */
    private function resolvePreviewUrl(array $fileMetaList): array
    {
        $fileSystem = $this->s3FileSystem;
        return array_map(function (FileMeta $fileMeta) use ($fileSystem) {
            $previewUrl = $fileSystem->preview(FileName::create($fileMeta->getName()));

            return $fileMeta->setPreviewUrl($previewUrl);
        }, $fileMetaList);
    }
}
