<?php

namespace App\Controller;
use App\Entity\Ingrediant;
use App\Entity\Cours;
use App\Entity\Planning;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Doctrine\ORM\EntityManagerInterface;

class IngrediantMobileController extends AbstractController
{
    #[Route('/mobile', name: 'app_ingrediant_mobile_client')]
    public function index(): Response
    {
        return $this->render('ingrediant/indexfront.html.twig', [
            'controller_name' => 'IngrediantMobileController',
        ]);
    }

    #[Route('/api/ingrediant/list', name: 'ingrediantList')]
    public function allIngrediantApi(Request $request,NormalizerInterface $normalizer): Response
    {
    $em = $this->getDoctrine()->getManager()->getRepository(Ingrediant::class)->findAll();      
    $jsonContent = $normalizer->normalize($em, 'json', ['groups' => 'post:read']);

    return new Response(json_encode($jsonContent));
    }


    #[Route('/api/addingrediantAPI', name: 'addIngrediantAPI')]
    public function addingrediantAPI(NormalizerInterface $Normalizer,Request $request): Response
    {
        $ingrediant= new Ingrediant();
    
        $em = $this->getDoctrine()->getManager();
        
        
        $ingrediant->setTitre((string) $request->query->get('titre'));
        $ingrediant->setCaloris((int)$request->query->get('caloris'));
        $ingrediant->setPoids((int)$request->query->get('poids'));

        
        $em->persist($ingrediant);
        $em->flush();
        $jsonContent = $Normalizer->normalize($ingrediant, 'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));

    }
       
    #[Route('/api/editIngrediantAPI/{id}', name: 'editIngrediantAPI')]
    public function editIngrediant ($id,Request $request,   NormalizerInterface $normalizer ): Response
    {   
        $em = $this->getDoctrine()->getManager();
        $ingrediant = $em->getRepository(Ingrediant::class)->find($id);
        var_dump($id);
    var_dump($ingrediant);
    $ingrediant->setTitre((string) $request->query->get('titre'));
    $ingrediant->setCaloris((int)$request->query->get('caloris'));
    $ingrediant->setPoids((int)$request->query->get('poids'));
        
        $em->persist($ingrediant);
       
        $em->flush();
        $jsonContent =$normalizer->normalize($ingrediant, 'json' ,['groups'=>'post:read']);
        return new Response("information updated successfully". json_encode($jsonContent));

    }


   
    #[Route('/api/deleteingrediantAPI/{id}', name: 'deleteIngrediantAPI')]

    public function deleteIngrediant(Request $request,NormalizerInterface $normalizer,$id): Response
    {

        $em = $this->getDoctrine()->getManager(); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES

        $c = $this->getDoctrine()->getManager()->getRepository(Ingrediant::class)->find($id); // ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES

            $em->remove($c);
            $em->flush();
            $jsonContent =$normalizer->normalize($c, 'json' ,['groups'=>'post:read']);
            return new Response("information deleted successfully".json_encode($jsonContent));
    }
    #[Route('/api/search', name: 'search_ingrediants', methods: ['GET','POST'])]
    public function searchIngrediants(Request $request, IngrediantRepository $ingrediantRepository)
    {
        $searchQuery = $request->query->get('searchQuery', '');
        
        $ingrediants = $ingrediantRepository->searchByTitre($searchQuery);
        $jsonContent =$normalizer->normalize($ingrediant, 'json' ,['groups'=>'post:read']);
        return new Response("information updated successfully". json_encode($jsonContent));
    }
}
