<?php

namespace App\Controller;

use App\Entity\InformationsPensionnaires;
use App\Entity\Pensionnaires;
use App\Form\InformationsPensionnairesType;
use App\Form\PensionnairesType;
use App\Repository\PensionnairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pensionnaires')]
class PensionnairesController extends AbstractController
{
    #[Route('/', name: 'app_pensionnaires_index', methods: ['GET'])]
    public function index(PensionnairesRepository $pensionnairesRepository): Response
    {
        return $this->render('pensionnaires/index.html.twig', [
            'pensionnaires' => $pensionnairesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pensionnaires_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pensionnaire = new Pensionnaires();
        $informationsPensionnaires = new InformationsPensionnaires();

        $form = $this->createForm(PensionnairesType::class, $pensionnaire);
        $form2 = $this->createForm(InformationsPensionnairesType::class, $informationsPensionnaires);
        $form->handleRequest($request);
        $form2->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && ($form2->isSubmitted() && $form2->isValid())) {

            $imageFile = $form->get('image_pensionnaire')->getData();
            if ($imageFile) {
                $imageName = uniqid().'.'.$imageFile->guessExtension();

                try {
                        $imageFile->move(
                        $this->getParameter('image_directory'), 
                        $imageName
                    );
                } catch (FileException $e) {
                    // Gérer les erreurs d'upload
                }

                $pensionnaire->setImagePensionnaire($imageName);
            }

            $entityManager->persist($pensionnaire);
            $entityManager->persist($informationsPensionnaires);
            $entityManager->flush();

            return $this->redirectToRoute('app_pensionnaires_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pensionnaires/new.html.twig', [
            'pensionnaire' => $pensionnaire,
            'informationsPensionnaires' => $informationsPensionnaires,
            'form' => $form,
            'form2' => $form2,
        ]);
    }

    #[Route('/{id}', name: 'app_pensionnaires_show', methods: ['GET'])]
    public function show(Pensionnaires $pensionnaire, InformationsPensionnaires $informationsPensionnaires): Response
    {
        return $this->render('pensionnaires/show.html.twig', [
            'pensionnaire' => $pensionnaire,
            'informationsPensionnaires' => $informationsPensionnaires,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pensionnaires_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pensionnaires $pensionnaire, InformationsPensionnaires $informationsPensionnaires, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PensionnairesType::class, $pensionnaire);
        $form2 = $this->createForm(InformationsPensionnairesType::class, $informationsPensionnaires);
        $form->handleRequest($request);
        $form2->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && ($form2->isSubmitted() && $form2->isValid()))  {
            $entityManager->flush();

            return $this->redirectToRoute('app_pensionnaires_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pensionnaires/edit.html.twig', [
            'pensionnaire' => $pensionnaire,
            'form' => $form,
            'form2' => $form2,
        ]);
    }

    #[Route('/{id}', name: 'app_pensionnaires_delete', methods: ['POST'])]
    public function delete(Request $request, Pensionnaires $pensionnaire, InformationsPensionnaires $informationsPensionnaires, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pensionnaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($pensionnaire);
            $entityManager->remove($informationsPensionnaires);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pensionnaires_index', [], Response::HTTP_SEE_OTHER);
    }
}
