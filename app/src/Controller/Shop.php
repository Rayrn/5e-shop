<?php

namespace App\Controller;

use App\Entity\Store;
use App\Repository\ItemRepository;
use App\Repository\StoreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class Shop
{
    private ItemRepository $itemRepository;
    private StoreRepository $storeRepository;

    public function __construct(ItemRepository $itemRepository, StoreRepository $storeRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->storeRepository = $storeRepository;
    }

    public function getShop(?int $id): Response
    {
        if ($id) {
            // lookup Store
        } else {
            $store = $this->generateStore();
        }

        print_r($store);

        return new JsonResponse(['message' => 'hi']);
    }

    private function getStore(int $id): ?Store
    {
        return $this->storeRepository->find($id);
    }

    private function generateStore(): Store
    {
        $store = new Store();

        foreach ([1, 2, 3] as $id) {
            $item = $this->itemRepository->find($id);

            if ($item) {
                $store->addItem($item);
            }
        }

        return $store;
    }
}
