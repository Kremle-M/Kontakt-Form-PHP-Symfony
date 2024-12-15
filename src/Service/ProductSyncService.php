<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;


class ProductSyncService
{
    private EntityManagerInterface $entityManager;
    private ProductApiService $productApiService;

    public function __construct(EntityManagerInterface $entityManager, ProductApiService $productApiService)
    {
        $this->entityManager = $entityManager;
        $this->productApiService = $productApiService;
    }

    public function sync(): array
    {
        $page = 1;
        $totalSynced = 0;
        $updatedCount = 0;
        $existingProductIds = [];

        do {
            $products = $this->productApiService->Products(100, $page);
            if (empty($products)) {
                break;
            }

            foreach ($products as $productData) {
                $externalId = $productData['id'] ?? null;
                if (!$externalId) {
                    continue;
                }

                $existingProductIds[] = $externalId;
                $product = $this->entityManager
                    ->getRepository(Product::class)
                    ->findOneBy(['externalId' => $externalId]);

                if (!$product) {
                    $product = new Product();
                    $product->setExternalId($externalId);
                    $product->setVytvoreni(new \DateTimeImmutable());
                }


                $product->setNazev($productData['title'] ?? '');
                $product->setZnacka($productData['brand'] ?? 'Neznámá značka');
                $product->setKatalogCislo($productData['sku'] ?? null);
                $product->setCenaCZK($this->convertToCZK($productData['price'] ?? 0));
                $product->setSkladem($productData['stock'] ?? 0);
                $product->setAktualizace(new \DateTime());
                $this->entityManager->persist($product);
                $updatedCount++;
            }

            $page++;
            $totalSynced += count($products);
            $this->entityManager->flush();
        } while (count($products) === 100);

        $this->removeMissingProducts($existingProductIds);
        $this->productApiService->notifyDiscord($totalSynced, $updatedCount);
        return ['total' => $totalSynced, 'updated' => $updatedCount];
    }

    private function removeMissingProducts(array $existingProductIds): void
    {
        $query = $this->entityManager->createQuery(
            'DELETE FROM App\Entity\Product p 
           WHERE p.externalId NOT IN (:existingIds)'
        );
        $query->setParameter('existingIds', $existingProductIds);
        $query->execute();
    }

    private function convertToCZK(float $priceInEuro): float
    {
        $response = $this->productApiService->ExchangeRate();
        $exchangeRate = $response['rate'] ?? 24.5;
        return $priceInEuro * $exchangeRate;
    }
}