<?php

namespace App\Controller;

use App\Repository\IngredientRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IngredientController extends AbstractController
{
    /**
     * @var IngredientRepository
     */
    private $ingredientRepository;
    public function __construct(IngredientRepository $ingredientRepository)
    {
        $this->ingredientRepository=$ingredientRepository;
    }
    #[Route('/ingredient', name: 'app_ingredient')]
    public function index(Request $request,PaginatorInterface $paginator): Response
    {
        $ingredients=$this->ingredientRepository->findAll();
        $pagination = $paginator->paginate(
            $ingredients, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('ingredient/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
}