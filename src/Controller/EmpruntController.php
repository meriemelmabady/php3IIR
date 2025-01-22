<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Livre;
use App\Entity\Emprunt;
use Symfony\Component\Security\Core\Security;
use App\Repository\LivreRepository;
use App\Repository\EmpruntRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class EmpruntController extends AbstractController
{
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/emprunt", name="emprunt_index", methods={"GET"})
     */
    public function index(EmpruntRepository $empruntRepository): Response
    {
        return $this->render('emprunt/index.html.twig', [
            'emprunts' => $empruntRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user/emprunter", name="emprunter")
     */
    public function emprunter(SessionInterface $session, LivreRepository $livresRepository): Response
    {
        $user = $this->security->getUser();
        
        // Check if user is logged in
        if (!$user) {
            $this->addFlash('error', 'You must be logged in to make an emprunt.');
            return $this->redirectToRoute('home');
        }

        // Check if cart is empty
        $panier = $session->get("panier", []);
        if (empty($panier)) {
            $this->addFlash('error', 'Your panier is empty.');
            return $this->redirectToRoute('home');
        }

        // Create new emprunt
        $emprunt = new Emprunt();
        $emprunt->setDataEmprunt(new \DateTime());
        $emprunt->addUser($user);
        $emprunt->setIsConfirmed(false);

        // Add books to emprunt
        foreach ($panier as $id => $quantite) {
            $livre = $livresRepository->find($id);
            if ($livre) {
                $emprunt->addLivre($livre);
            }
        }

        // Persist and save
        $this->entityManager->persist($emprunt);
        $this->entityManager->flush();

        // Clear cart
        $session->remove('panier');

        $this->addFlash('success', 'Emprunt created successfully.');
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/admin/emprunt/{id}", name="emprunt_show", methods={"GET"})
     */
    public function show(Emprunt $emprunt): Response
    {
        return $this->render('emprunt/show.html.twig', [
            'emprunt' => $emprunt,
        ]);
    }

    /**
     * @Route("/emprunt/{id}", name="emprunt_delete", methods={"POST"})
     */
    public function delete(Request $request, Emprunt $emprunt = null): Response
    {
        if (!$emprunt) {
            $this->addFlash('error', 'Emprunt not found.');
            return $this->redirectToRoute('emprunt_index');
        }

        if ($this->isCsrfTokenValid('delete' . $emprunt->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($emprunt);
            $this->entityManager->flush();
            $this->addFlash('success', 'Emprunt deleted successfully.');
        }

        return $this->redirectToRoute('emprunt_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/admin/emprunt/confirm/{id}", name="confirm_emprunt")
     */
    public function confirmEmprunt(Emprunt $emprunt): Response
    {
        $emprunt->setIsConfirmed(true);
        $this->entityManager->flush();

        $this->addFlash('success', 'Emprunt confirmed successfully.');
        return $this->redirectToRoute('emprunt_index');
    }

    /**
     * @Route("/user/my-emprunts", name="user_emprunts")
     */
    public function userEmprunts(EmpruntRepository $empruntRepository): Response
    {
        $user = $this->security->getUser();
        if (!$user) {
            $this->addFlash('error', 'You must be logged in to view your emprunts.');
            return $this->redirectToRoute('home');
        }

        $emprunts = $empruntRepository->findBy(['user' => $user]);
        
        return $this->render('emprunt/user_emprunts.html.twig', [
            'emprunts' => $emprunts,
        ]);
    }

    /**
     * @Route("/admin/emprunt/stats", name="emprunt_stats", methods={"GET"})
     */
    public function getStats(EmpruntRepository $empruntRepository): Response
    {
        $stats = [
            'total_emprunts' => $empruntRepository->count([]),
            'pending_emprunts' => $empruntRepository->count(['isConfirmed' => false]),
            'confirmed_emprunts' => $empruntRepository->count(['isConfirmed' => true]),
        ];

        return $this->json($stats);
    }

    private function make_emprunt_data(SessionInterface $session, LivreRepository $livresRepository, Emprunt $emprunt)
    {
        $panier = $session->get("panier", []);
        $dataPanier = [];
        $total = 0;
        
        foreach ($panier as $id => $quantite) {
            $livre = $livresRepository->find($id);
            if ($livre) {
                $dataPanier[] = [
                    "livre" => $livre,
                    "quantite" => $quantite
                ];
                $this->fill_emprunt($emprunt, $livre);
                $total += $livre->getPrix() * $quantite;
            }
        }
        
        return $emprunt;
    }

    private function fill_emprunt(Emprunt $emprunt, Livre $livre)
    {
        $emprunt->addLivre($livre);
    }
}