<?php

namespace App\Controller;

use App\Entity\Courses;
use App\Form\CoursesType;
use App\Repository\CoursesRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/home/admin/courses')]
final class CoursesController extends AbstractController
{
    #[Route('/', name: 'app_courses')]
    public function index(CoursesRepository $coursesRepository): Response
    {
        return $this->render('courses/index.html.twig', [
            'courses' => $coursesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_courses_new')]
    public function new(Request $request, EntityManagerInterface $em, FileUploader $fileUploader): Response
    {
        $fname = 'Gini';
        $course = new Courses();
        $form = $this->createForm(CoursesType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form -> getData());
            $brochureFile = $form->get('picture')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $course->setPicture($brochureFileName);
            }
            $em->persist($course);
            $em->flush();

            return $this->redirectToRoute('app_courses');
        }

        return $this->render('courses/new.html.twig', [
            'fname' => $fname,
            'course' => $course,
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_courses_edit')]
    
    public function edit(Request $request, Courses $course, EntityManagerInterface $em, FileUploader $fileUploader): Response
    {
        $fname = 'Gini';
        $form = $this->createForm(CoursesType::class, $course);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('picture')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $course->setPicture($brochureFileName);
            }
            $em->persist($course);
            $em->flush();
            return $this->redirectToRoute('app_courses');
        }

        return $this->render('courses/edit.html.twig', [
            'fname' => $fname,
            'course' => $course,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_courses_show')]
    public function show(Courses $course): Response
    {
        $fname = 'Yasmina';
        return $this->render('courses/show.html.twig', [
            'fname' => $fname,
            'course' => $course,
        ]);
    }

    #[Route('/{id}', name: 'app_courses_delete', methods: ['POST', 'DELETE'])]
    public function delete(Request $request, Courses $course, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$course->getId(), $request->getPayload()->getString('_token'))) {
            $em->remove($course);
            $em->flush();
        }

        return $this->redirectToRoute('app_courses');
    }
}
