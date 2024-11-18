<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Types;
use App\Form\TypesFormType;
use App\Repository\TypesRepository;


// Sécurité qui permet uniquement à l'administrateur d'accèder à ces routes
#[Route('/admin/type', name: 'admin.type.')]
class TypeController extends AbstractController
{
    #[Route(name: 'index')]
    public function index(TypesRepository $repository): Response
    {
    
        return $this->render('admin/type/index.html.twig', [
            'types' => $repository->findAll() // récupère l'ensemble des Types de manga présent dans la BDD
        ]);
    }

    // Route qui permet de créer un Type de manga
    #[Route('/create', name: 'create')]
    public function createType(Request $request,EntityManagerInterface $em): Response
    {
        $type = new Types; // créer un nouvel objet Type
        $form = $this->createForm(TypesFormType::class, $type);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($type);
            $em->flush();
            $this->addFlash('success', 'Le type a bien été créer');
            return $this->redirectToRoute('admin.type.index');
        }
        return $this->render('admin/type/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    // Route qui permet d'éditer un Type
    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function editTypeAction(Types $types, Request $request, EntityManagerInterface $em) : Response
    {   
        $form = $this->createForm(TypesFormType::class, $types);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            $this->addFlash("success", "Le type a bien été modifié");
            return $this->redirectToRoute('admin.type.index');
        }
        return $this->render('admin/type/edit.html.twig', [
            'type' => $types,
            'form' => $form
        ]);

    }

    // Route qui permet de supprimer un Type
    #[Route('/delete/{id}', name: 'delete', methods: ['DELETE'], requirements: ['id' => '\d+'])]
    public function deleteType(Types $types, EntityManagerInterface $em) : Response
    {
        $em->remove($types);
        $this->addFlash('success', "Le type a bien été supprimé");
        return $this->redirectToRoute('admin.type.index');
    }
}
