<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\LivreRepository;
use App\Repository\EmpruntRepository;
use App\Repository\CategorieRepository;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    private $userRepository;
    private $livreRepository;
    private $empruntRepository;
    private $categorieRepository;

    public function __construct(
        UserRepository $userRepository,
        LivreRepository $livreRepository,
        EmpruntRepository $empruntRepository,
        CategorieRepository $categorieRepository
    ) {
        $this->userRepository = $userRepository;
        $this->livreRepository = $livreRepository;
        $this->empruntRepository = $empruntRepository;
        $this->categorieRepository = $categorieRepository;
    }

    /**
     * @Route("", name="admin")
     */
    public function index(): Response
    {
        // Get total counts
        $usersCount = $this->userRepository->count([]);
        $booksCount = $this->livreRepository->count([]);
        $empruntsCount = $this->empruntRepository->count(['isConfirmed' => true]);
        $categoriesCount = $this->categorieRepository->count([]);

        // Get recent emprunts (last 5)
        $recentEmprunts = $this->empruntRepository->findBy(
            [], // criteria
            ['DataEmprunt' => 'DESC'], // order by
            5 // limit
        );

        // Get pending emprunts count
        $pendingEmpruntsCount = $this->empruntRepository->count(['isConfirmed' => false]);

        return $this->render('admin/index.html.twig', [
            'users_count' => $usersCount,
            'books_count' => $booksCount,
            'emprunts_count' => $empruntsCount,
            'categories_count' => $categoriesCount,
            'recent_emprunts' => $recentEmprunts,
            'pending_emprunts' => $pendingEmpruntsCount
        ]);
    }

    /**
     * @Route("/stats", name="admin_stats", methods={"GET"})
     */
    public function getStats(): Response
    {
        $monthlyStats = $this->empruntRepository->getMonthlyStats();
        
        return $this->json([
            'monthly_stats' => $monthlyStats,
            'total_users' => $this->userRepository->count([]),
            'total_books' => $this->livreRepository->count([]),
            'active_loans' => $this->empruntRepository->count(['isConfirmed' => true]),
            'pending_loans' => $this->empruntRepository->count(['isConfirmed' => false])
        ]);
    }

    /**
     * @Route("/dashboard", name="admin_dashboard")
     */
    public function dashboard(): Response
    {
        // You can add more specific dashboard data here if needed
        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/overview", name="admin_overview")
     */
    public function overview(): Response
    {
        $stats = [
            'total_revenue' => $this->empruntRepository->getTotalRevenue(),
            'active_users' => $this->userRepository->getActiveUsers(),
            'popular_books' => $this->livreRepository->getPopularBooks(),
            'recent_activities' => $this->empruntRepository->getRecentActivities()
        ];

        return $this->render('admin/overview.html.twig', [
            'stats' => $stats
        ]);
    }
}