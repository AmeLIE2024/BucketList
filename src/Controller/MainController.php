<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController{
    #[Route('/', name: 'app_main')]
    public function home(): Response
    {
        return $this->render('main/home.html.twig', [
            'title' => 'Home',
        ]);
    }
    #[Route('/test', name: 'app_main_test')]
    public function test(): Response
    {
        $serie = [
            "title" => "Game of Thrones",
            "year" => 2000
           ];
        return $this->render('main/test.html.twig', [
            "mySerie" => $serie,
            "autreVar" => 412412
        ]);
    }
}
