<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Products;

final class ProductsController extends AbstractController
{
    #[Route('/products', name: 'app_products', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
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
}