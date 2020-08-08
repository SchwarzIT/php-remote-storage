<?php

namespace App\Controller;

use Chapterphp\FileSystem\FileSystemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DownloadController extends AbstractController
{
    /**
     * @Route("/download/{file_name}", name="download")
     */
    public function __invoke(Request $request, FileSystemInterface $fileSystem): Response
    {
    }
}
