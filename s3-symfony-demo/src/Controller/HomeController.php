<?php

namespace App\Controller;

use Chapterphp\FileSystem\Model\FileMeta;
use Chapterphp\FileSystem\Model\FileName;
use Chapterphp\FileSystem\RemoteAdapterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $s3Adapter;

    public function __construct(RemoteAdapterInterface $s3Adapter)
    {
        $this->s3Adapter = $s3Adapter;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $fileMetaList = $this->s3Adapter->list();

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
        $fileSystem = $this->s3Adapter;

        return array_map(
            function (FileMeta $fileMeta) use ($fileSystem) {
                $previewUrl = $fileSystem->preview(FileName::create($fileMeta->getName()));

                return $fileMeta->setPreviewUrl($previewUrl);
            },
            $fileMetaList
        );
    }
}
