<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MangakaType;
use App\Entity\Mangaka;
use App\Repository\MangakaRepository;


// Sécurité qui permet uniquement à l'administrateur d'accèder à ces routes
#[Route('/admin/mangaka', name: 'admin.mangaka.')]
class MangakaController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(MangakaRepository $repository): Response
    {

        $mangakas = $repository->findAll(); // permet de récupérer tous les mangas

        return $this->render('admin/mangaka/index.html.twig', [
            'mangakas' => $mangakas,
        ]);
    }

    // Permet de créer un mangaka
    #[Route('/create', name: 'create')]
    public function createMangaka(Request $request, EntityManagerInterface $em): Response
    {
        $mangaka = new Mangaka(); // créer un nouvel Objet Mangaka
        $form = $this->createForm(MangakaType::class, $mangaka);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($mangaka);
            $em->flush();
            $this->addFlash('success', 'Le mangaka a bien été créer');
            return $this->redirectToRoute('admin.mangaka.index');
        }
        return $this->render('admin/mangaka/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Permet d'éditer un mangaka
    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])] 
    public function editMangaka (Mangaka $mangaka,Request $request, EntityManagerInterface $em) : Response
    {
        $form = $this->createForm(MangakaType::class, $mangaka);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            $this->addFlash('success', "Le mangaka a bien été modifié");
            return $this->redirectToRoute('admin.mangaka.index');
        }

        return $this->render('admin/mangaka/edit.html.twig', [
            'mangaka' => $mangaka,
            'fomr' => $form
        ]);
    }

    // Permet de supprimer un mangaka
    #[Route('/delete/{id}', name: 'delete', methods: ['DELETE'], requirements: ['id' => '\d+'])]
    public function deleteMangaka(Mangaka $mangaka, EntityManagerInterface $em) : Response
    {
        $em->remove($mangaka);
        $em->flush();
        $this->addFlash("success", "le mangaka a bien été supprimé");
        return $this->redirectToRoute("admin.mangaka.index");

    }
}
