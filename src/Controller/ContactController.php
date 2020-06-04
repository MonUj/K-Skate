<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $contact = $form->getData();

            //Ici nous enverrons le mail
            $message = (new \Swift_Message('Nouveau contact'))
                // On attribue l'expéditeur
                ->setFrom($contact['email'])

                // On attribue le destinataire
                ->setTo('julienroyau49@gmail.com')

                // On créer le message avec la vue Twig
                ->setBody(
                    $this->renderView('emails/contact.html.twig', compact('contact')
                ),
                'text/html'
                )
            ;

            // On envoie le message 
            $mailer->send($message);

            $this->addFlash('message', 'Le message a bien été envoyé.');
            return $this->redirectToRoute('app_home');
        }
        
        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }


    
}
