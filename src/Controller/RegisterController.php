<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var UserPasswordHasherInterface
     */
    private $encoder;
    public function __construct(EntityManagerInterface $manager,UserPasswordHasherInterface $encoder)
    {
        $this->manager=$manager;
        $this->encoder=$encoder;
    }
    #[Route('/register', name: 'app_register')]
    public function index(Request $request): Response
    {
        $user=new User();
        $form=$this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user=$form->getData();
            $hash=$this->encoder->hashPassword($user,$user->getPassword());
            $user->setPassword($hash);
            $this->manager->persist($user);
            $this->manager->flush();
            $this->addFlash('success','user added successfully');
            return $this->redirectToRoute("app_login");
        }
        return $this->render('register/index.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}