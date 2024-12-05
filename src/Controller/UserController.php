<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CoursesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/home/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user')]
    public function index(CoursesRepository $coursesRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'courses' => $coursesRepository->findAll(),
        ]);
    }
}

