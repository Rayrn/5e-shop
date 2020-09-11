<?php

namespace App\ViewTransformer;

use App\Entity\Armour;
use App\ViewModel\ItemModel;

class ArmourTransformer
{
    public function transform(Armour $armour, ItemModel $itemModel): ItemModel
    {
        $itemModel->core = $this->buildArmourString(
            $armour->armourClassBase,
            $armour->armourClassBonus,
            $armour->maxDexterityModifier
        );

        $itemModel->notes = $this->buildArmourNotes(
            $armour->armourType,
            $armour->minStrength,
            $armour->stealthDisadvantage
        );

        return $itemModel;
    }

    private function buildArmourString(?int $ac, ?int $acBonus, ?int $maxDex): string
    {
        if ($ac) {
            $armourString = 'AC ';
            $armourString .= ($ac + (int) $acBonus);

            if ($maxDex !== 0) {
                $armourString .= " + Dex modifier";
            }

            if ($maxDex > 0) {
                $armourString .= " (Max $maxDex)";
            }

            return trim($armourString);
        }

        return "+$acBonus AC";
    }

    private function buildArmourNotes(string $armourType, ?int $minStrength, bool $stealthDisadvantage): string
    {
        $pieces = [];
        $pieces[] = $armourType !== 'shield'
            ? ucfirst($armourType) . ' armour'
            : ucfirst($armourType);

        if ($minStrength) {
            $pieces[] = "Requires Str $minStrength";
        }

        if ($stealthDisadvantage) {
            $pieces[] = "Disadvantage on Stealth";
        }

        return implode(', ', $pieces);
    }
}
