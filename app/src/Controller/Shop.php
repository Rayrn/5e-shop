<?php

namespace App\Controller;

use App\Entity\Store;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class Shop
{
    public function getShop(?int $id): Response
    {
        if ($id) {
            // lookup Store
        } else {
            $store = $this->generateStore();
            $this->persistStore($store);
        }

        return new JsonResponse(['message' => 'hi']);
    }

    private function getStore(int $id): ?Store
    {
    }

    private function generateStore(): Store
    {
        return new Store();
    }

    private function persistStore(Store $store): bool
    {
        return true;
    }
}
