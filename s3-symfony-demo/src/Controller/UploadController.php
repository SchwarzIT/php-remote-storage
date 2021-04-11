<?php

namespace App\Controller;

use Chapterphp\FileSystem\Model\File;
use Chapterphp\FileSystem\RemoteAdapterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    /**
     * @Route("/upload", name="upload", methods={"POST"})
     */
    public function __invoke(Request $request, RemoteAdapterInterface $s3Adapter): Response
    {
        $file = File::createFromUpload($request->files->get('upload'));

        $s3Adapter->save($file);

        return new Response(null, 201);
    }
}
