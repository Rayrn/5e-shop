<?php

namespace App\ViewTransformer;

use App\Entity\Item;
use App\ViewModel\ItemModel;

class ItemTransformer
{
    public function transform(Item $item): ItemModel
    {
        $itemModel = new ItemModel();

        switch ($item->itemType) {
            case 'armour':
                $itemModel = $this->buildArmour($item, $itemModel);
                break;
            case 'weapon':
                $itemModel = $this->buildWeapon($item, $itemModel);
                break;
            default:
                $itemModel = $this->buildItem($item, $itemModel);
                break;
        }

        return $itemModel;
    }

    private function buildItem(Item $item, ItemModel $itemModel): ItemModel
    {
        $itemModel->name = $item->name;
        $itemModel->cost = $this->buildCostString($item->cost);
        $itemModel->weight = $item->weight . ' lb';

        return $itemModel;
    }

    private function buildArmour(Item $item, ItemModel $itemModel): ItemModel
    {
        $itemModel = $this->buildItem($item, $itemModel);

        return $itemModel;
    }

    private function buildWeapon(Item $item, ItemModel $itemModel): ItemModel
    {
        $itemModel = $this->buildItem($item, $itemModel);

        return $itemModel;
    }

    private function buildCostString(float $cost): string
    {
        $gp = (int) $cost;
        $sp = ($cost * 100) % 100;

        $costString = '';
        if ($gp) {
            $costString = "{$gp} gp";
        }

        if ($sp) {
            $costString .= " {$sp} sp";
        }

        return trim($costString);
    }
}
