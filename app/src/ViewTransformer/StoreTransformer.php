<?php

namespace App\ViewTransformer;

use App\Entity\Store;
use App\ViewModel\StoreModel;

class StoreTransformer
{
    private ItemTransformer $itemTransformer;

    public function __construct(ItemTransformer $itemTransformer)
    {
        $this->itemTransformer = $itemTransformer;
    }

    public function transform(Store $store): StoreModel
    {
        $model = new StoreModel();
        $model->name = $store->name;

        foreach ($store->listItems() as $item) {
            $model->addItem($this->itemTransformer->transform($item));
        }

        return $model;
    }
}
