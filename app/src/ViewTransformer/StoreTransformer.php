<?php

namespace App\ViewTransformer;

use App\Entity\Store;
use App\ViewModel\StoreModel;
use Doctrine\Common\Collections\Collection;

class StoreTransformer
{
    private ItemTransformer $itemTransformer;

    public function __construct(ItemTransformer $itemTransformer)
    {
        $this->itemTransformer = $itemTransformer;
    }

    public function transform(int $id, string $name, Collection $items): StoreModel
    {
        $model = new StoreModel();
        $model->id = $id;
        $model->name = $name;

        foreach ($items as $item) {
            $model->addItem($this->itemTransformer->transform($item));
        }

        return $model;
    }
}
