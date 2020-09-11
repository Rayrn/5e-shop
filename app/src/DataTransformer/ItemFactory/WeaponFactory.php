<?php

namespace App\DataTransformer\ItemFactory;

use App\DataTransformer\ItemFactoryInterface;
use App\Entity\Item;
use App\Entity\Weapon;

class WeaponFactory implements ItemFactoryInterface
{
    public function build(array $config): ?Item
    {
        $item = new Weapon();

        foreach ($config as $key => $value) {
            if (property_exists(Weapon::class, $key)) {
                $item->$key = $value;
            }
        }

        return $item;
    }

    public function upgrade(Item $weapon): Item
    {
        if (!$weapon instanceof Weapon || $weapon->itemLevel == 'masterwork') {
            return $weapon;
        }

        if ($weapon->itemLevel == 'superior') {
            $weapon->damageBonus += 1;
            $weapon->cost *= 10;
            $weapon->name = str_replace('Superior', 'Masterwork', $weapon->name);
            $weapon->itemLevel = 'masterwork';

            return $weapon;
        }

        $weapon->damageBonus += 1;
        $weapon->cost = $weapon->cost < 1
            ? $weapon->cost * 1000
            : $weapon->cost *= 10;
        $weapon->name = "Superior {$weapon->name}";
        $weapon->itemLevel = 'superior';

        return $weapon;
    }

    public function supports(string $itemType): bool
    {
        return $itemType === 'weapon';
    }
}
