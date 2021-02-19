<?php

namespace App\Controller\admin;

use App\Entity\Aliment;
use App\Form\AlimentType;
use App\Repository\AlimentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{    
    /**
     * @Route("/admin", name="admin_index")
     */
    public function index(AlimentRepository $repository): Response
    {
        $aliments = $repository->findAll();
        return $this->render('admin/index.html.twig', [
            'aliments' => $aliments
        ]);
    }

    /**
     * @Route("/admin/ajouter-aliment", name="admin_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        // On instancie un nouvel objet de la classe Aliment()
        $aliment = new Aliment();

        $form = $this->createForm(AlimentType::class, $aliment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion des images
            $img = $form->get('image')->getData();
            // On génère un nom unique pour nos fichiers image
            $fichier = md5(uniqid()). '.' .$img->guessExtension() ;
            // On copie l'image dans le dossier images
            $img->move(
                $this->getParameter('images_aliments'),
                $fichier
            );

            $manager->persist($aliment);
            $manager->flush();

            $this->addFlash(
              'success',
              "L'aliment ". $aliment->getNom() . ' a bien été ajouté'  
            );

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/create.html.twig', [
            'aliment' => $aliment,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/modification/{id}", name="admin_update")
     */
    public function update(AlimentRepository $repository, Request $request, EntityManagerInterface $manager, $id): Response
    {
        // On récupère l'aliment via son id avec la fonction find()
        $aliment = $repository->find($id);

        // On créé le formulaire avec la fonction createForm()
        // Le premier paramètre est le formulaire à créer
        // Le second paramètre est l'Objet Aliment
        $form = $this->createForm(AlimentType::class, $aliment);

        /* 
         On vérifie si le formulaire a été traité en utilisant la 
         fonction handleRequest() sur la requête envoyé à notre serveur par le 
         biais de l'injection de dépendance (Request $request)
        */
        $form->handleRequest($request);
        /* 
         On vérifie si le formulaire a bien été soumis et
         si il est valide
        */
        if ($form->isSubmitted() && $form->isValid()) {
            /* 
             On persiste l'objet aliment grâce au manager (injection de dépendance) 
             persist() = pré-enregistre les modifications
            */
            $manager->persist($aliment);
            /*
             flush() = on enregistre définitivement les modifications en base de données
            */
            $manager->flush();

            // Message flash pour informer que la modification a bien été éffectuée
            $this->addFlash(
                'success',
                "L'aliment ". $aliment->getNom() . " a bien été modifié"  
              );

            // On redirige vers la page admin_index après soumission du formulaire
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/update.html.twig', [
            'aliment' => $aliment,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/supprimer/{id}", name="admin_delete")
     */
    public function delete(Aliment $aliment, Request $request, EntityManagerInterface $manager) 
    {
        /* 
         La fonction isCsrfTokenValid() remplace en quelque sorte la fonction isValid()
         Le mécanisme de base d’une attaque CSRF c'est quoi ? 
         Il s’agit de faire envoyer à un utilisateur une requête vers un site, à son insu, pour y déclencher une action.
        */
        if ($this->isCsrfTokenValid("delete". $aliment->getId(), $request->get('_token'))) {
            $manager->remove($aliment);
            $manager->flush();
            
            $this->addFlash(
                'danger',
                "L'aliment ". $aliment->getNom() . ' a bien été supprimé'  
              );

            return $this->redirectToRoute('admin_index');
        }
    }

}
