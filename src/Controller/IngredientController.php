<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
    /**
     * Undocumented function
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
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

    #[Route('/ingredient/new', name: 'app_ingredient_new')]
    public function new(Request $request): Response
    {
        $ingredient=new Ingredient();
        $form=$this->createForm(IngredientType::class,$ingredient);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $ingredient=$form->getData();
            $this->ingredientRepository->save($ingredient,true);
            $this->addFlash('success','Ingredient ajouté avec succès');
            return $this->redirectToRoute('app_ingredient');
        }
        return $this->render('ingredient/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/ingredient/update/{id}','app_ingredient_update',methods:['GET','POST'])]
    public function update(Request $request,$id): Response
    {
        $ingredient=$this->ingredientRepository->findOneBy(['id'=>$id]);
        if(!$ingredient){
            $this->addFlash('success','ingrédient introuvable');
            return $this->redirectToRoute('app_ingredient');
        }
        $form=$this->createForm(IngredientType::class,$ingredient);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $ingredient=$form->getData();
            $this->ingredientRepository->save($ingredient,true);
            $this->addFlash('success','Ingredient modifié avec succès');
            return $this->redirectToRoute('app_ingredient');
        }
        return $this->render('ingredient/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/ingredient/delete/{id}','app_ingredient_delete',methods:['GET'])]
    public function delete($id): Response
    {
        $ingredient=$this->ingredientRepository->findOneBy(['id'=>$id]);
        if(!$ingredient){
            $this->addFlash('success','ingrédient introuvable');
            return $this->redirectToRoute('app_ingredient');
        }
        $this->ingredientRepository->remove($ingredient,true);
        $this->addFlash('success','Ingredient supprimé avec succès');
        return $this->redirectToRoute('app_ingredient');
        return $this->render('ingredient/update.html.twig');
    }
}