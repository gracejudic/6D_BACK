<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Ads;
use App\Entity\Products;
use Symfony\Component\HttpFoundation\Response;
use App\Enum\StatusEnum;
use ArrayObject;

final class AdsController extends AbstractController
{   
    private int $NUMBEROFADS = 6;

    #[Route('/ads', name: 'app_ads', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupérer les annonces depuis la base de données
        $ads = $entityManager->getRepository(Ads::class)->findAll();

        // Préparer les données pour la réponse JSON
        $adsData = [];
        foreach ($ads as $ad) {
            $adsData[] = [
                'id' => $ad->getId(),
                'title' => $ad->getTitle(),
                'created_at' => $ad->getCreatedAt(),
                'status' => $ad->getStatus(),

                // Ajoutez d'autres champs selon vos besoins
            ];
        }

        // Retourner les données sous forme de JSON
        return $this->json($adsData);
    }

    #[Route('/ads/showAd/{id}', name: 'add_show')]
    public function showAd(EntityManagerInterface $entityManager, int $id): JSONResponse
    {
        $ad = $entityManager->getRepository(Ads::class)->find($id);

        if (!$ad) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product_id = $ad->getProductId();
        $product = $entityManager->getRepository(Products::class)->find($product_id);

        return $this->json([
            'ad' => $ad->getTitle(),
            'created_at' => $ad->getCreatedAt(),
            'product_name' =>  $product->getName(),
            'description' => $product->getDescription(),
            // rajouter des infos
        ]);
    }


    // ne marche pas.....
    #[Route('/ads/showAd/', name: 'add_show_all')]
    public function showAllAd(EntityManagerInterface $entityManager): JsonResponse
    {
        $ads = $entityManager->getRepository(Ads::class)->findAll();

        if (!$ads) {
            throw $this->createNotFoundException(
                'No product found'
            );
        }

        $product = $entityManager->getRepository(Products::class)->findAll();

        $arrayCollection = array();

        foreach($ads as $item) {
            $arrayCollection[] = array(
                'id' => $item->getId(),
                'title' => $item->getTitle(),
                'created_at' => $product->getCreatedAt(),
                'product_name' =>  $product->getName(),
                'description' => $product->getDescription()
            );
        }

        return new JsonResponse($arrayCollection);

    }



    #[Route('/ads/add-dummy-data', name:"add-data")]
    public function addDummyData(EntityManagerInterface $entityManager): Response
    {
        $titleArray = ['Canapé Le Bambole en velours moutarde par Mario Bellini pour B&B Italia, 1970',
        'Série de 4 chaises en pin, années 70',
        'Serie de 3 chaises bistrot 1950',
        'Canapé en cuir produit par Hurup Møbelfabrik, Danemark, années 1970.',
        'Table à manger extensible des années 60 par Bramin',
        'Table à manger ronde extensible en teck du milieu du siècle de Nathan, années 1960'];

        $typeArray = ['Canapé', 'Chaise', 'Chaise', 'Canapé', 'Table', 'Table'];

        $dimensionsArray = [
            'H72 x L178 x P142',
            'H100 x L43 x P44',
            'H80 x L38 x P46',
            'H81 x L216 x P81',
            'H75 x L135 x P90',
            'H76 x L124 x P124'
        ];

        $priceArray = [5950, 290, 160, 2250, 2400, 1290];

        $colorArray = [
            'moutarde',
            'Bois',
            'Bois',
            'Noir',
            'Bois',
            'Bois'
        ];

        $materialArray = [
            'Velours',
            'Pin',
            'Bois',
            'Cuir',
            'Bois',
            'Teck'
        ];

        $productConditionArray = [
            'Excellent',
            'Excellent',
            'Bon',
            'Excellent',
            'Excellent',
            'Excellent'
        ];

        $descriptionArray = [
            'Superbe canapé deux places « Le Bambole » conçu par Mario Bellini pour B&B Italia dans les années 1970. Une belle édition en velours de coton moutarde de haute qualité avec un joli toucher doux ajoutant à ce design confortable et « chunky ». Outre son confort exceptionnel, ce canapé emblématique est célèbre pour son look intemporel. La collection « Le Bambole » a reçu le prix « Compasso d\'Oro » en 1979. Un exemple de Le Bambole est inclus dans la collection permanente du MoMA. Dimensions : L178 x P98 x H72 cm Période : Années 1970 Etat : Excellent',
            'Petit coup de coeur pour cette série de chaises en pin massif aux lignes absolument graphiques, typés aztèques. Parfaitement stables et solides, elles sont présentées ici dans leur patine d\'origine et présentent donc des traces légères d\'utilisation passée. La fusion entre style savoyard et mexicain.',
            'Très belle série de 3 chaises de bistrot 1950. Elles sont en bon état. Dans leur jus. Elles ont une belle patine. Il y en a une qui est plus foncée que les 2 autres. C\'est un très joli modèle. Elles mesurent 38.5 cm de large sur 46 cm de profondeur. Et 80 cm de haut. La hauteur d\'assise est de 45.5 cm.',
            'Hurup møbelfabrik était l\'un des principaux fabricants de meubles du danemark, réputé pour son savoir-faire de haute qualité de 1959 jusqu\'à sa fermeture en 2011. Ce canapé présente une structure et des pieds en hêtre massif, associés à un revêtement en cuir noir haut de gamme. Les coussins en duvet restent moelleux et confortables. Le canapé est en excellent état, seuls quelques signes d\'usure étant visibles sur les photos.',
            'Rare table à manger extensible en teck des années 1960 par hw klein pour bramin. Structure solide et plateau plaqué avec chant en bois massif. La rallonge se range sous le plateau. Fabriquée au danemark. Design : hw klein, fabricant : bramin.',
            'Cette table à manger ronde extensible a été fabriquée par le fabricant britannique nathan dans les années 1960. Les éléments en teck ont été nettoyés de l\'ancienne surface et peints avec une teinture chêne et finis avec un vernis semi-mat résistant. La table est dotée d\'un mécanisme qui permet de l\'étendre facilement de 124 cm à 170 cm.'
        ];

        for ($i = 0; $i < $this->NUMBEROFADS; $i++) {
            $ad = new Ads();
            $product = new Products();
            
            $product->setName($titleArray[$i]);
            $product->setDescription($descriptionArray[$i]);
            $product->setType($typeArray[$i]);
            $product->setDimensions($dimensionsArray[$i]);
            $product->setMaterial($materialArray[$i]);
            $product->setProductCondition($productConditionArray[$i]);
            $product->setPrice($priceArray[$i]);
            $product->setColor($colorArray[$i]);

            $entityManager->persist($product);
            $entityManager->flush();

            $ad->setTitle($titleArray[$i]);
            $ad->setProductId($product->getId());
            $ad->setCreatedAt(new \DateTimeImmutable());
            $ad->setStatus(StatusEnum::VALIDATED);
            $ad->setUserId(1);

            $entityManager->persist($ad);
            $entityManager->flush();
        }
        
        return new Response('Created lots of dummy data');
    }
}
