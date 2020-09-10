<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Store;
use App\DataTransformer\ItemLevelTransformer;
use App\Repository\ItemRepository;
use App\Repository\StoreRepository;
use App\ViewTransformer\StoreTransformer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class StoreController
{
    private ItemLevelTransformer $itemLevelTransformer;
    private ItemRepository $itemRepository;
    private StoreRepository $storeRepository;
    private StoreTransformer $storeTransformer;

    public function __construct(
        ItemRepository $itemRepository,
        StoreRepository $storeRepository,
        ItemLevelTransformer $itemLevelTransformer,
        StoreTransformer $storeTransformer
    ) {
        $this->itemRepository = $itemRepository;
        $this->storeRepository = $storeRepository;
        $this->itemLevelTransformer = $itemLevelTransformer;
        $this->storeTransformer = $storeTransformer;
    }

    public function newStore(): Response
    {
        $store = $this->generateStore();

        return $this->outputStore($store);
    }

    public function getStore(Request $request): Response
    {
        $id = $request->attributes->get('id');

        $store = $this->storeRepository->find($id);

        return $this->outputStore($store);
    }

    public function outputStore(?Store $store): Response
    {
        if (!$store) {
            return new JsonResponse(['message' => 'Store missing or failed to load'], 404);
        }

        return new JsonResponse($this->storeTransformer->transform($store)->asArray());
    }

    private function generateStore(): Store
    {
        $store = new Store();
        $store->name = 'New store';

        foreach (range(1, 30) as $id) {
            $item = $this->itemRepository->find($id);

            if ($item) {
                $store->addItem($this->setItemLevel($item, 90, 100));
            }
        }

        return $store;
    }

    private function setItemLevel(Item $item, int $superiorThreshold, int $masterworkThreshold): Item
    {
        if ($item->itemType == 'item') {
            return $item;
        }

        $dice = rand(1, 100);

        if ($dice > $masterworkThreshold) {
            return $this->itemLevelTransformer->makeMasterwork($item);
        }

        if ($dice > $superiorThreshold) {
            return $this->itemLevelTransformer->makeSuperior($item);
        }

        return $item;
    }
}
