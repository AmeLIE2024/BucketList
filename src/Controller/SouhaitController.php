<?php

namespace App\Controller;

use App\Entity\Souhait;
use App\Form\SouhaitType;
use App\Repository\SouhaitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;


#[Route('/souhait', name: 'souhait')]
final class SouhaitController extends AbstractController
{
    //route pour affichage de la liste de souhaits
    #[Route('', name: '_list', methods: ['GET'])]
    public function list(SouhaitRepository $souhaitRepository): Response
    {

 //       $souhaits = $souhaitRepository->findAll();

        //affichage des souhaits par ordre alhpabétique de nom et dans la limite de 5 par page
 //       $souhaits = $souhaitRepository->findBy([], ['name' => 'DESC'],5);

        //appel de la requête créée dans le repo
        $souhaits = $souhaitRepository->findLastSouhaits();
        return $this->render('souhait/list.html.twig', [
            'souhaits' => $souhaits
        ]);

    }

    //route pour affichage du détail d'un souhait
    #[Route('/{id}', name: '_detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function detail(Souhait $souhait, SouhaitRepository $souhaitRepository): Response
    {
  //      $souhait = $souhaitRepository->find($id);
  //      if (!$souhait) {
  //          throw $this->createNotFoundException('Souhait inconnu');
  //      }
        return $this->render('souhait/detail.html.twig',[
            'souhait'=>$souhait
        ]);
    }

    //route de création d'un souhait
    #[Route('/ajouter', name: '_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $souhait = new Souhait();
        $souhaitForm = $this->createForm(SouhaitType::class, $souhait);
        $souhaitForm->handleRequest($request);
        //TODO: traiter le formulaire
        if($souhaitForm->isSubmitted() && $souhaitForm->isValid()){
            $em->persist($souhait);
            $em->flush();
            $this->addFlash('success', 'le souhait a bien été enregistré');
            return $this->redirectToRoute('souhait_list');
        }
        //dump($request);
        return $this->render('souhait/create.html.twig', [
            'souhaitForm' => $souhaitForm
        ]);
    }

    //route de modification d'en cours
    #[Route('/{id}/modifier', name: '_update', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function update(Souhait $souhait, Request $request, EntityManagerInterface $em): Response
    {
        $souhaitForm = $this->createForm(SouhaitType::class, $souhait);
        $souhaitForm->handleRequest($request);
        if($souhaitForm->isSubmitted() && $souhaitForm->isValid()){
            $souhait->setModifiedAt(new \DateTimeImmutable());
            $em->flush();
            $this->addFlash('success', 'Le souhait a bien été modifié');
            return $this->redirectToRoute('souhait_detail', ['id' => $souhait->getId()]);
        }
        return $this->render('souhait/update.html.twig', [
            'souhaitForm' => $souhaitForm
        ]);

    }
    //Methode demo
    #[Route('/demo', name: '_demo',  methods: ['GET'])]
    public function demo(EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        //créer une instance de l'entité
        $souhait = new souhait();
        //hydrater toutes les propriétés obligatoires
        $souhait->setName('Chats');
        $souhait->setContent('Je voudrais avoir une brassée de chatons trop mignons !');
        $souhait->setCreatedAt(new \DateTimeImmutable());
        $souhait->setIsPublished(true);

        $errors = $validator->validate($souhait);
        if (count($errors) == 0) {
            $em->persist($souhait);
            $em->flush();
            return $this->redirectToRoute('souhait_detail' , ['id' => $souhait->getId()]);
        }
        dd($errors);

        $em->persist($souhait);
        dump($souhait);
        $em->persist($souhait);
        $em->flush();
        dump($souhait);

        //modification de l'objet
        $souhait->setName('Chatounets');
        //sauvegarde de l'objet
        $em->flush();
        dump($souhait);

        //supression
        $em->remove($souhait);
        $em->flush();


        //TODO:rechercher le souhait das la BDD avec son ID
        return $this->render('souhait/create.html.twig');
    }

}
