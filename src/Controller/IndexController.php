<?php

namespace App\Controller;

use App\Form\SignupFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    public function __construct(public readonly EntityManagerInterface $em) {}

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $form = $this->createForm(SignupFormType::class);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();
            $confirm = $form->get('confirmPassword')->getData();

            if (!$password === $confirm) {  
                throw new \Exception('Passwords do not match');
            }

            // $this->em->persist($form->getData());
            // $this->em->flush();
        }

        return $this->render('views/index.html.twig', [
            'form'=> $form->createView(),
        ]);
    }
}
