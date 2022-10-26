<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerTestController extends AbstractController
{
  
    public function __construct(private MailerInterface $mailerInterface)
    {
        
    }

    #[Route('/mailer/test', name: 'app_mailer_test')]
    public function index(Request $request): Response
    {
        $contact= new Contact;
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email= (new Email())
            ->from('eg.renovads@gmail.com')
            ->to($contact->getEmailSender())
            ->subject('contact form customer')
            ->text($contact->getMessage());

        $this->mailerInterface->send($email);
        // $mailin = new Email();
        // $mailin->
        // addTo('eg.renovads@gmail.com', 'etienne guignard')->
        // from('eg.renovads@gmail.com', 'etienne guignard')->
        // replyTo('eg.renovads@gmail.com','etienne guignard')->
        // subject("Entrer l'objet ici")
        // ->text('Bonjour')
        // ->html('<strong>Bonjour</strong>');
        // $this->mailerInterface->send($mailin);

        }

        // $mailin = new Email();
        // $mailin->
        // addTo('eg.renovads@gmail.com', 'etienne guignard')->
        // from('eg.renovads@gmail.com', 'etienne guignard')->
        // replyTo('eg.renovads@gmail.com','etienne guignard')->
        // subject("Entrer l'objet ici")
        // ->text('Bonjour')
        // ->html('<strong>Bonjour</strong>');
        // $this->mailerInterface->send($mailin);
        /**

        */
        
        return $this->render('mailer_test/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
