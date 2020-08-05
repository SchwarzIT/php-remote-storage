<?php

namespace App\Controller;

use Chapterphp\FileSystem\FileSystemInterface;
use Chapterphp\FileSystem\Model\FileName;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(FileSystemInterface $fileSystem): Response
    {
        $fileName = FileName::create('scu.png');
        $fileSystem->delete($fileName);


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
