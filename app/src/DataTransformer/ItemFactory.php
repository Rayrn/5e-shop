<?php

namespace App\DataTransformer;

use App\Entity\Item;

class ItemFactory
{
    public function build(array $config): Item
    {
        $item = new Item();

        foreach (get_class_vars(Item::class) as $key => $value) {
            if (array_key_exists($key, $config)) {
                $item->$key = $config[$key];
            }
        }

        return $item;
    }
}
