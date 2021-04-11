<?php

namespace App\Controller;

use Chapterphp\FileSystem\Model\FileName;
use Chapterphp\FileSystem\RemoteAdapterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * @Route("/delete/{file_name}", name="delete", methods={"DELETE"})
     */
    public function __invoke(Request $request, RemoteAdapterInterface $s3Adapter): Response
    {
        $fileName = $request->get('file_name');
        $s3Adapter->delete(FileName::create($fileName));

        return new Response(null, 200);
    }
}
