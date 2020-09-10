<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Store;
use App\DataTransformer\ItemFactoryInterface;
use App\Repository\ItemRepository;
use App\ViewTransformer\StoreTransformer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class StoreController
{
    private ItemFactoryInterface $itemFactory;
    private ItemRepository $itemRepository;
    private StoreTransformer $storeTransformer;

    public function __construct(
        ItemRepository $itemRepository,
        ItemFactoryInterface $itemFactory,
        StoreTransformer $storeTransformer
    ) {
        $this->itemRepository = $itemRepository;
        $this->itemFactory = $itemFactory;
        $this->storeTransformer = $storeTransformer;
    }

    public function getStore(Request $request): Response
    {
        $id = $request->attributes->get('id')
            ? (int) $request->attributes->get('id')
            : rand(1, 100000);

        $format = $request->attributes->get('_format');

        return $this->outputStore($this->generateStore($id), $format);
    }

    private function outputStore(?Store $store): Response
    {
        if (!$store) {
            return new JsonResponse(['message' => 'Store missing or failed to load'], 404);
        }

        return new JsonResponse($this->storeTransformer->transform($store)->asArray());
    }

    private function generateStore(int $id): Store
    {
        srand($id);

        $store = new Store($id);
        $store->name = 'New store';

        $superiorThreshold = rand(80, 90); // 1:5 to 1:10
        $masterworkThreshold = rand(95, 99); // 1:20 to 1:100

        $maxId = $this->itemRepository->getMaxId();

        for ($i = 0; $i < rand(3, 40); $i++) {
            $item = $this->itemRepository->find(rand(1, $maxId));

            if ($item) {
                $store->addItem(
                    $this->upgradeItem($item, $superiorThreshold, $masterworkThreshold)
                );
            }
        }

        return $store;
    }

    private function upgradeItem(Item $item, int $superiorThreshold, int $masterworkThreshold): Item
    {
        $dice = rand(1, 100);
        if ($dice > $superiorThreshold) {
            $item = $this->itemFactory->upgrade($item);
        }

        $dice = rand(1, 100);
        if ($dice > $masterworkThreshold) {
            $item = $this->itemFactory->upgrade($item);
        }

        return $item;
    }
}
