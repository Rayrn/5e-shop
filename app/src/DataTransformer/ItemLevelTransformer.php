<?php

namespace App\DataTransformer;

use App\Entity\Armour;
use App\Entity\Item;
use App\Entity\Weapon;

class ItemLevelTransformer
{
    public function makeMasterwork(Item $item): Item
    {
        $item->itemLevel = 'masterwork';
        $item->name = "Masterwork {$item->name}";

        $item->cost = $item->cost > 1
            ? $item->cost * 10
            : $item->cost * 100;

        if ($item instanceof Armour) {
            $item->armourClassBonus += 2;
        }

        if ($item instanceof Weapon) {
            $item->damageBonus = 2;
        }

        return $item;
    }

    public function makeSuperior(Item $item): Item
    {
        $item->itemLevel = 'superior';
        $item->name = "Superior {$item->name}";

        $item->cost = $item->cost > 1
            ? $item->cost * 2
            : $item->cost * 20;

        if ($item instanceof Armour) {
            $item->armourClassBonus += 1;
        }

        if ($item instanceof Weapon) {
            $item->damageBonus = 1;
        }

        return $item;
    }
}
