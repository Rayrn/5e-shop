<?php

namespace App\ViewTransformer;

use App\Entity\Armour;
use App\Entity\Item;
use App\Entity\Weapon;
use App\ViewModel\ItemModel;

class ItemTransformer
{
    private ArmourTransformer $armourTransformer;
    private WeaponTransformer $weaponTransformer;

    public function __construct(ArmourTransformer $armourTransformer, WeaponTransformer $weaponTransformer)
    {
        $this->armourTransformer = $armourTransformer;
        $this->weaponTransformer = $weaponTransformer;
    }

    public function transform(Item $item): ItemModel
    {
        if ($item instanceof Armour) {
            return $this->armourTransformer->transform($item, $this->buildItem($item));
        }

        if ($item instanceof Weapon) {
            return $this->weaponTransformer->transform($item, $this->buildItem($item));
        }

        return $this->buildItem($item);
    }

    private function buildItem(Item $item): ItemModel
    {
        $itemModel = new ItemModel();
        $itemModel->name = $item->name;
        $itemModel->cost = $this->buildCostString($item->cost);
        $itemModel->weight = $item->weight . ' lb';

        return $itemModel;
    }

    private function buildCostString(float $cost): string
    {
        $gp = (int) $cost;
        $sp = ($cost * 100) % 100;

        $pieces = [];
        if ($gp) {
            $pieces[] = "{$gp} gp";
        }

        if ($sp) {
            $pieces[] = "{$sp} sp";
        }

        return implode(' ', $pieces);
    }
}
