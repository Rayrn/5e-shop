<?php

namespace App\DataTransformer\ItemFactory;

use App\DataTransformer\ItemFactoryInterface;
use App\Entity\Item;

class ItemFactory implements ItemFactoryInterface
{
    public function build(array $config): ?Item
    {
        $item = new Item();

        foreach (get_class_vars(Item::class) as $key => $value) {
            if (array_key_exists($key, $config)) {
                $item->$key = $config[$key];
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
