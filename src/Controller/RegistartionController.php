<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistartionController extends AbstractController
{
    #[Route('/registartion', name: 'app_registartion')]
    public function index(): Response
    {
        return $this->render('registartion/index.html.twig', [
            'controller_name' => 'RegistartionController',
        ]);
    }
}
