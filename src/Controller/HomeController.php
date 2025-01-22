<?php

namespace App\Controller;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Repository\LivreRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(LivreRepository $livreRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'livres' => $livreRepository->findLastest(),
        ]);
    }
    /**
     * @Route("/collection", name="collection")
     */
    public function colletion(LivreRepository $livreRepository,CategorieRepository $categorieRepository): Response
    {
        return $this->render('home/collection.html.twig', [
            'controller_name' => 'HomeController',
            'livres' => $livreRepository->findOrdred(),
            'categories' => $categorieRepository->findOrdred(),
        ]);
    }

     /**
     * @Route("/book/{id}", name="single_book", methods={"GET"})
     */
    public function show(Livre $livre): Response
    {
        return $this->render('home/show_livre.html.twig', [
            'livre' => $livre,
        ]);
    }


    /**
     * @Route("/search", name="search_livre")
     */
    public function searchLivre(Request $request)
    {

        $titre = $request->query->get('titre');

        $em  = $this->getDoctrine()->getManager();
        $req = $em->createQuery('
            SELECT l FROM App\Entity\Livre l
            WHERE l.titre LIKE :titre
            ORDER BY l.titre ASC'
        )
        ->setParameter('titre','%'.$titre.'%')
        ->setMaxResults(10);
        $resultat = $req->getResult();
        return $this->render('home/search_result.html.twig', [
            'resultat' => $resultat,
        ]);
    }
    # Add these methods to your controller:

/**
 * @Route("/about", name="about")
 */
public function about(): Response
{
    return $this->render('home/about.html.twig');
}

/**
 * @Route("/contact", name="contact")
 */
public function contact(Request $request): Response
{
    return $this->render('home/contact.html.twig');
}

/**
 * @Route("/contact/submit", name="contact_submit", methods={"POST"})
 */
public function contactSubmit(Request $request, MailerInterface $mailer): Response
{
    if ($this->isCsrfTokenValid('contact-form', $request->request->get('token'))) {
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $phone = $request->request->get('phone');
        $subject = $request->request->get('subject');
        $message = $request->request->get('message');

        // Create email
        $email = (new Email())
            ->from($email)
            ->to('your@email.com')
            ->subject('Contact Form: ' . $subject)
            ->html($this->renderView(
                'home/emails/contact.html.twig',
                [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'subject' => $subject,
                    'message' => $message,
                ]
            ));

        try {
            $mailer->send($email);
            $this->addFlash('success', 'Thank you for your message. We\'ll get back to you soon!');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Sorry, there was an error sending your message. Please try again later.');
        }

        return $this->redirectToRoute('contact');
    }

    $this->addFlash('error', 'Invalid form submission.');
    return $this->redirectToRoute('contact');
}
    
}
