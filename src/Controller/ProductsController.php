<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Products;
use App\Enum\ProductEnum;

final class ProductsController extends AbstractController
{
    #[Route('/products', name: 'app_products', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        header("Access-Control-Allow-Origin: http://localhost:5173");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        // Récupérer les produits depuis la base de données
        $products = $entityManager->getRepository(Products::class)->findAll();

        // Préparer les données pour la réponse JSON
        $productsData = [];
        foreach($products as $product) {
            $productsData [] = [
                'id' => $product -> getId(),
                'name' => $product -> getName(),
                'description' => $product -> getDescription(),
                'type' => $product -> getType(),
                'dimensions'=> $product -> getDimensions(),
                'material' => $product -> getMaterial(),
                'color' => $product -> getColor(),
                'product_condition' => $product -> getProductCondition(),
                'price' => $product -> getPrice(),
                
            ];
        }

        return $this->json($productsData);
    }
    #[Route('/products/{id}', name: 'product_show', methods: ['GET'])]
    public function show(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        header("Access-Control-Allow-Origin: http://localhost:5173");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        $product = $entityManager->getRepository(Products::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        $productData = [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'type' => $product->getType(),
            'dimensions' => $product->getDimensions(),
            'material' => $product->getMaterial(),
            'color' => $product->getColor(),
            'product_condition' => $product->getProductCondition()->value, // Utilisez ->value pour l'enum
            'price' => $product->getPrice(),
        ];

        return $this->json($productData);
    }
}