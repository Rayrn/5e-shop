<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Armour extends Item
{
    public const ARMOUR_TYPE = ['light', 'medium', 'heavy', 'shield'];

    /**
     * @Assert\Choice(Armour::ARMOUR_TYPE)
     * @ORM\Column(type="string")
     */
    public string $armourType;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */

    public ?int $armourClassBase;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    public ?int $armourClassBonus;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    public ?int $maxDexterityModifier;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    public ?int $minStrength;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $stealthDisadvantage = false;
}
