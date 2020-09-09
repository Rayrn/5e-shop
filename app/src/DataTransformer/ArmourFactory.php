<?php

namespace App\DataTransformer;

use App\Entity\Armour;

class ArmourFactory
{
    public function build(array $config): Armour
    {
        $item = new Armour();

        foreach (get_class_vars(Armour::class) as $key => $value) {
            if (array_key_exists($key, $config)) {
                $item->$key = $config[$key];
            }
        }

        return $item;
    }
}
