<?php

namespace App\DataTransformer\ItemFactory;

use App\DataTransformer\ItemFactoryInterface;
use App\Entity\Armour;
use App\Entity\Item;

class ArmourFactory implements ItemFactoryInterface
{
    public function build(array $config): ?Item
    {
        $item = new Armour();

        foreach ($config as $key => $value) {
            if (property_exists(Armour::class, $key)) {
                $item->$key = $value;
            }
        }

        return $item;
    }

    public function upgrade(Item $armour): Item
    {
        if (!$armour instanceof Armour || $armour->itemLevel == 'masterwork') {
            return $armour;
        }

        if ($armour->itemLevel == 'superior') {
            $armour->armourClassBonus += 1;
            $armour->cost *= 5;
            $armour->name = str_replace('Superior', 'Masterwork', $armour->name);
            $armour->itemLevel = 'masterwork';

            return $armour;
        }

        $armour->armourClassBonus += 1;
        $armour->cost *= 2;
        $armour->name = "Superior {$armour->name}";
        $armour->itemLevel = 'superior';

        return $armour;
    }

    public function supports(string $itemType): bool
    {
        return $itemType === 'armour';
    }
}
