<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\GenreRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\GenreType;
use App\Entity\Genre;
use Doctrine\ORM\EntityManager;

#[Route('/admin/genre', name: 'admin.genre.')]
class GenreController extends AbstractController
{   
    // Permet d'afficher l'ensemble des genres
    #[Route(name: 'index')]
    public function index(GenreRepository $repository): Response
    {
        return $this->render('admin/genre/index.html.twig', [
            'genres' => $repository->findAll() // Récupère tous les genres présent dans la BDD
        ]);
    }

    // Permet de créer un genre
    #[Route('/create', name: 'create')]
    public function createGenre(Request $request, EntityManagerInterface $em): Response
    {
        $genre = new Genre(); // créer un nouvel objet Genre
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($genre);
            $em->flush();
            $this->addFlash('success', 'Le genre a bien été crée');
            return $this->redirectToRoute('admin.genre.index');
        }
        return $this->render('admin/genre/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    // Permet d'éditer un genre
    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function editGenre(Genre $genre, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($genre);
            $em->flush();
            $this->addFlash('success', 'Le genre a bien été modifié');
            return $this->redirectToRoute('admin.genre.index');
        }
        return $this->render('admin/genre/edit.html.twig', [
            'genre' => $genre, 
            'form' => $form->createView()
        ]);
    }

    // Cette route permet de supprimer un genre
    #[Route('/delete/{id}', name: 'delete', methods: ['DELETE'], requirements: ['id' => '\d+'])]
    public function deleteGenre(Genre $genre, EntityManagerInterface $em)
    {
        $em->remove($genre);
        $em->flush();
        $this->addFlash('success', 'Le genre a bien été supprimé');
        return $this->redirectToRoute('admin.genre.index');
    }
}
