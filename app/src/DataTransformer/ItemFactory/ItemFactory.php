<?php

namespace App\DataTransformer\ItemFactory;

use App\DataTransformer\ItemFactoryInterface;
use App\Entity\Item;

class ItemFactory implements ItemFactoryInterface
{
    public function build(array $config): ?Item
    {
        $item = new Item();

        foreach ($config as $key => $value) {
            if (property_exists(Item::class, $key)) {
                $item->$key = $value;
            }
        }

        return $item;
    }

    public function upgrade(Item $item): Item
    {
        return $item;
    }

    public function supports(string $itemType): bool
    {
        return $itemType === 'item';
    }
}
