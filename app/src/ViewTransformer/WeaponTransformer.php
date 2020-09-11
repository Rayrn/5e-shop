<?php

namespace App\ViewTransformer;

use App\Entity\Armour;
use App\Entity\Item;
use App\Entity\Weapon;
use App\ViewModel\ItemModel;

class WeaponTransformer
{
    private const PROPERTY_KEYS = [
        'ammuntion' => 'Ammuntion',
        'finesse' => 'Finesse',
        'heavy' => 'Heavy',
        'light' => 'Light',
        'loading' => 'Loading',
        'reach' => 'Reach',
        'twoHanded' => 'Two-Handed',
        'thrown' => 'Thrown',
        'versatile' => 'Versatile',
        'special' => 'Special'
    ];

    public function transform(Weapon $weapon, ItemModel $itemModel): ItemModel
    {
        $itemModel->core = $this->buildDamageString(
            $weapon->damageDiceType,
            $weapon->damageDiceNumber,
            $weapon->damageBonus,
            $weapon->damageType
        ) . ' damage';

        $itemModel->notes = $this->buildWeaponNotes($weapon);

        return $itemModel;
    }

    private function buildDamageString(?int $dice, ?int $number, ?int $damageBonus, string $damageType): string
    {
        $damageString = '';

        if ($dice && $number) {
            $damageString = "{$number}d{$dice}";
        }

        if ($damageString && $damageBonus) {
            $damageString .= '+';
        }

        if ($damageBonus) {
            $damageString .= $damageBonus;
        }

        if ($damageType) {
            $damageString .= " $damageType";
        }

        return $damageString;
    }

    private function buildWeaponNotes(Weapon $weapon): string
    {
        $pieces = [];
        $pieces[] = ucfirst($weapon->weaponType) . " weapon";

        foreach (self::PROPERTY_KEYS as $key => $value) {
            if ($weapon->$key === true) {
                $pieces[$key] = $value;
            }
        }

        foreach (['ammuntion', 'thrown'] as $key) {
            if (isset($pieces[$key])) {
                $pieces[$key] .= " ({$weapon->shortRange}/{$weapon->longRange})";
            }
        }

        if (isset($pieces['versatile'])) {
            $versatileDamageString = $this->buildDamageString(
                $weapon->versatileDamageDice,
                $weapon->versatileDamageDiceNumber,
                $weapon->damageBonus,
                ''
            );

            $pieces['versatile'] .= " ($versatileDamageString)";
        }

        return implode(', ', $pieces);
    }
}
