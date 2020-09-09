<?php

namespace App\Controller;

use App\Entity\Store;
use App\DataTransformer\ConfigTransformer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class Shop
{
    private ConfigTransformer $configTransformer;

    public function __construct(ConfigTransformer $configTransformer)
    {
        $this->configTransformer = $configTransformer;
    }

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

    public function listItems(): Response
    {
        return new JsonResponse($this->configTransformer->listItems('assets/item-config.yaml')->toArray());
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
