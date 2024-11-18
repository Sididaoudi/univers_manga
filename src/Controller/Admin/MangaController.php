<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\MangaType;
use App\Entity\Manga;
use App\Repository\MangaRepository;


// Sécurité qui permet uniquement à l'administrateur d'accèder à ces routes
#[Route('/admin/manga', name: 'admin.manga.')]
class MangaController extends AbstractController
{   
    #[Route('/', name: 'index')]
    public function index(MangaRepository $repository): Response
    {   

        $mangas = $repository->findAll(); // permet de récupérer tous les mangas

        return $this->render('admin/manga/index.html.twig', [
            'mangas' => $mangas,
        ]);
    }

    // Route qui permet de créer un manga
    #[Route('/create', name: 'create')]
    public function createManga(Request $request, EntityManagerInterface $em): Response
    {   
        $manga = new Manga(); // créer un nouvel objet Manga
        $form = $this->createForm(MangaType::class, $manga); // utilise le formularie propre à Symfony
        $form->handleRequest($request); // permet de traiter la requête HTTP et de remplir le formulaire avec les données soumises. Sans cet appel, les données soumises ne seront pas traitées, et le formulaire ne sera pas validé.
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em->persist($manga);
            $em->flush(); // insertion du manga dans la BDD
            $this->addFlash('success', "Le manga a bien été crée");
            return $this->redirectToRoute('admin.manga.index');
        }
        return $this->render('admin/manga/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // Route qui permet d'éditer un manga
    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])] 
    public function editManga(Manga $manga, Request $request, EntityManagerInterface $em): Response
    {
       $form = $this->createForm(MangaType::class, $manga);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid())
       {
            $em->flush();
            $this->addFlash('success', "le manga a bien été modifié");
            return $this->redirectToRoute("admin.manga.index");
       }
        return $this->render('admin/manga/edit.html.twig', [
            'manga' => $manga,
            'form' => $form,
        ]);
    }

    // Route qui permet de supprimer un manga
    #[Route('/delete/{id}', name: 'delete', methods: ['DELETE'], requirements: ['id' => '\d+'])]
    public function deleteManga(Manga $manga, EntityManagerInterface $em): Response
    {
        $em->remove($manga);
        $em->flush();
        $this->addFlash("success", "le manga a bien été supprimé");
        return $this->redirectToRoute("admin.manga.index");
    }	
}
