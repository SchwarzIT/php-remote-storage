<?php

namespace App\Controller;

use Chapterphp\FileSystem\FileSystemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DownloadController extends AbstractController
{
    /**
     * @deprecated Download can be done directly by using previewUrl, see HomeController::resolvePreviewUrl()
     *
     * @Route("/download", name="download")
     */
    public function __invoke(Request $request, FileSystemInterface $fileSystem): Response
    {
        return new Response(null,200);
    }
}
