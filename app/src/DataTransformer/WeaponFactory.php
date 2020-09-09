<?php

namespace App\DataTransformer;

use App\Entity\Weapon;

class WeaponFactory
{
    public function build(array $config): Weapon
    {
        $item = new Weapon();

        foreach (get_class_vars(Weapon::class) as $key => $value) {
            if (array_key_exists($key, $config)) {
                $item->$key = $config[$key];
            }
        }

        return $item;
    }
}
