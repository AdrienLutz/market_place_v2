<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\ProduitsType;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


use App\Repository\CategoriesRepository;
use App\Repository\DistributeursRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use function MongoDB\BSON\fromJSON;

#[Route('/produits')]
class ProduitsController extends AbstractController
{

    #[Route('/index', name: 'app_produits_index', methods: ['GET'])]
    public function index(ProduitsRepository $produitsRepository): Response
    {
        return $this->render('produits/index.html.twig', [
            'produits' => $produitsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_produits_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produits();
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produits/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}/', name: 'app_produits_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produits/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }





    #[Route('/show/{id}', name: 'app_produits_show', methods: ['GET'])]
    public function show(Produits $produit): Response
    {
        return $this->render('produits/show.html.twig', [
            'produit' => $produit,
        ]);
    }
    #[Route('/delete/{id}', name: 'app_produits_delete', methods: ['POST'])]
    public function delete(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
    }


//    ---------------- autres routes pour tester différentestechniques



    # requêtes DQL
    #[Route('/produits_dql', name:'app_produits_dql')]
    /**
     * Afficher tous les produits via findAll de ProduitsRepository et l'injection de dependance
     * Tester les requetes DQL pour le cours de Symfony
     *
     * @param ProduitsRepository $produitRepository
     * @return Response
     */
    public function afficherProduits(ProduitsRepository $produitsRepository): Response {

        return $this->render('produits/afficher_produits.html.twig',[
            'produits' =>$produitsRepository->getAllProductsByIdDescDQL()
        ]);
    }

    # requetes "croisées"
    #TODO : à reprendre ...

    //    #[Route('/{id}', name: 'app_produits_distributeur')]
//    public function getProduitByDistributeur(
//        Request $request,
//        ProduitsRepository $produitsRepository
//    ): Response {
//        $distributeurID = $request->request->get("distributeur_id");
//        $resultat = $produitsRepository->produitByDistributeur($distributeurID);
//
//        return $this->render('produits/produit-distributeur.html.twig',[
//            'produits => $resultat'
//        ]);
//    }

    # serialisation de données
    #[Route("/produits-json", name: "app_produits_api")]
    public function produitsAPI(
        ProduitsRepository $produitsRepository,
        SerializerInterface $serializer
    ):JsonResponse{
        $produits = $produitsRepository->findAll();
        $produits_to_json = $serializer->serialize($produits, 'json', ['groups'=> 'produits']);

        return new JsonResponse($produits_to_json, Response::HTTP_OK, [], true);
    }

    #[Route("/afficher-produits-json", name: "app_produits_json")]
    public function afficherProduitsJson():Response{
        return $this->render('produits/afficher_produits_json.html.twig');
    }


}
