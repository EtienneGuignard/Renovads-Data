<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Form\CampaignType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CampaignController extends AbstractController
{
    #[Route('/campaign', name: 'app_campaign')]
    public function index(): Response
    {
        return $this->render('campaign/index.html.twig', [
            'controller_name' => 'CampaignController',
        ]);
    }
    #[Route('/campaign/create', name: 'add_campaign')]
    public function addCampaign(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $campaign= new Campaign;
        $form= $this->createForm(CampaignType::class, $campaign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 

            $entityManagerInterface->persist($campaign);
            $entityManagerInterface->flush();
        }

        return $this->render('campaign/addCampaign.html.twig', [
            'controller_name' => 'CampaignController',
            'form'=> $form->createView(),
        ]);
    }
}
