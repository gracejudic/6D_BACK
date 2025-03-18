<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Pictures;
use App\Entity\Products;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PicturesRepository;

final class PicturesController extends AbstractController
{
    #[Route('/pictures/first/{productId}', name: 'app_pictures_first', methods: ['GET'])]
public function getFirstPicture(int $productId, PicturesRepository $picturesRepository): JsonResponse
{
    header("Access-Control-Allow-Origin: http://localhost:5173");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");


    $picture = $picturesRepository->findOneBy(['product_id' => $productId]);

    if (!$picture) {
        return $this->json(['error' => 'No picture found'], Response::HTTP_NOT_FOUND);
    }

    return $this->json(['url' => $picture->getUrl()]);
}


    #[Route('/pictures/all/{productId}', name: 'app_pictures_all', methods: ['GET'])]
    public function getAllPictures(int $productId, PicturesRepository $picturesRepository): JsonResponse
    {
        header("Access-Control-Allow-Origin: http://localhost:5173");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        $pictures = $picturesRepository->findBy(['product_id' => $productId]);
    
        if (!$pictures) {
            return $this->json(['error' => 'No pictures found'], Response::HTTP_NOT_FOUND);
        }
    
        $urls = array_map(fn($pic) => $pic->getUrl(), $pictures);
    
        return $this->json(['urls' => $urls]);
    }



    #[Route('/pictures', name: 'app_pictures')]
    public function index(): JsonResponse
    {
        header("Access-Control-Allow-Origin: http://localhost:5173");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PicturesController.php',
        ]);
    }

    #[Route('/pictures/add-dummy-pictures')]
    public function addDummyPictures(EntityManagerInterface $entityManager): Response
    {
        header("Access-Control-Allow-Origin: http://localhost:5173");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        $products = $entityManager->getRepository(Products::class)->findAll();
        
        $pictureUrls = [
            [
            "Canapé%20Le%20Bambole%20en%20velours%20moutarde%201.webp",
            "Canapé%20Le%20Bambole%20en%20velours%20moutarde%202.webp",
            "Canapé%20Le%20Bambole%20en%20velours%20moutarde%203.webp",
            "Canapé%20Le%20Bambole%20en%20velours%20moutarde%204.webp",
            "Canapé%20Le%20Bambole%20en%20velours%20moutarde%205.webp",
            "Canapé%20Le%20Bambole%20en%20velours%20moutarde%206.webp"
            ],
            [
            "Série%20de%204%20chaises%20en%20pin,%20années%2070%201.webp",
            "Série%20de%204%20chaises%20en%20pin,%20années%2070%202.webp",
            "Série%20de%204%20chaises%20en%20pin,%20années%2070%203.webp",
            "Série%20de%204%20chaises%20en%20pin,%20années%2070%204.webp",
            "Série%20de%204%20chaises%20en%20pin,%20années%2070%206.webp"
            ],
            [
            "Série%20de%203%20chaises%20bistrot%201950%201.webp",
            "Série%20de%203%20chaises%20bistrot%201950%202.webp",
            "Série%20de%203%20chaises%20bistrot%201950%203.webp",
            "Série%20de%203%20chaises%20bistrot%201950%204.webp",
            "Série%20de%203%20chaises%20bistrot%201950%205.webp",
            ],
            [
            "Canapé%20en%20cuir%20produit%20par%20Hurup%20Møbelfabrik,%20Danemark,%20années%201970%201.webp",
            "Canapé%20en%20cuir%20produit%20par%20Hurup%20Møbelfabrik,%20Danemark,%20années%201970%202.webp",
            "Canapé%20en%20cuir%20produit%20par%20Hurup%20Møbelfabrik,%20Danemark,%20années%201970%203.webp",
            "Canapé%20en%20cuir%20produit%20par%20Hurup%20Møbelfabrik,%20Danemark,%20années%201970%204.webp",
            "Canapé%20en%20cuir%20produit%20par%20Hurup%20Møbelfabrik,%20Danemark,%20années%201970%205.webp"
            ],
            [
            "Table%20à%20manger%20extensible%20des%20années%2060%20par%20Bramin%201.webp",
            "Table%20à%20manger%20extensible%20des%20années%2060%20par%20Bramin%202.webp",
            "Table%20à%20manger%20extensible%20des%20années%2060%20par%20Bramin%203.webp",
            "Table%20à%20manger%20extensible%20des%20années%2060%20par%20Bramin%204.webp",
            "Table%20à%20manger%20extensible%20des%20années%2060%20par%20Bramin%205.webp"
            ],
            [
            "Table%20à%20manger%20ronde%20extensible%20en%20teck%201.webp",
            "Table%20à%20manger%20ronde%20extensible%20en%20teck%202.webp",
            "Table%20à%20manger%20ronde%20extensible%20en%20teck%203.webp",
            "Table%20à%20manger%20ronde%20extensible%20en%20teck%204.webp",
            "Table%20à%20manger%20ronde%20extensible%20en%20teck%205.webp",
            ]
        ];
            
        for ($i=0; $i < sizeof($pictureUrls); $i++) { 
            for ($j=0; $j < sizeof($pictureUrls[$i]); $j++) {
                $picture = new Pictures(); 
                $picture->setUrl('..\pictures\\' . $pictureUrls[$i][$j]);
                $picture->setProductId($i+1);
                $entityManager->persist($picture);
            }
        }
        $entityManager->flush();

        return new Response('Saved new pictures');
    }
}
