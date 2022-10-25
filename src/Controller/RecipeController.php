<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{   
/**
 * @var RecipeRepository
 */
    private $recipeRepository;
    public function __construct(RecipeRepository $recipeRepository)
    {
        $this->recipeRepository=$recipeRepository;
    }
    #[Route('/recipe', name: 'app_recipe')]
    public function index(PaginatorInterface $paginator,Request $request): Response
    {
        $recipes=$this->recipeRepository->findAll();
        $pagination = $paginator->paginate(
            $recipes, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('recipe/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    #[Route('/recipe/update/{id}', name: 'app_recipe_update')]
    public function update(Request $request,$id): Response
    {
        $recipe=$this->recipeRepository->findOneBy(['id'=>$id]);
        $form=$this->createForm(RecipeType::class,$recipe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $recipe=$form->getData();
            $this->recipeRepository->save($recipe,true);
            $this->addFlash('success','recipe added successfully');
            return $this->redirectToRoute('app_recipe');
        }
        return $this->render('recipe/update.html.twig', [
            'form' => $form->createView(),
            'recipe'=>$recipe
        ]);
    }

    #[Route('/recipe/new', name: 'app_recipe_new')]
    public function new(Request $request): Response
    {
        $recipe=new Recipe();
        $form=$this->createForm(RecipeType::class,$recipe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $recipe=$form->getData();
            $this->recipeRepository->save($recipe,true);
            $this->addFlash('success','recipe added successfully');
            return $this->redirectToRoute('app_recipe');
        }
        return $this->render('recipe/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/recipe/delete/{id}', name: 'app_recipe_delete')]
    public function delete($id): Response
    {
        $recipe=$this->recipeRepository->findOneBy(['id'=>$id]);
        if(!$recipe){
            $this->addFlash('success','recipe deleted successfully');
            return $this->redirectToRoute('app_recipe');
        }
        $this->recipeRepository->remove($recipe,true);
        return $this->redirectToRoute('app_recipe');
    }
}