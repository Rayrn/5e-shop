<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Weapon extends Item
{
    public const DAMAGE_DICE = [null, 4, 6, 8, 10, 12];
    public const DAMAGE_TYPE = ['bludgeoning', 'piercing', 'slashing'];
    public const WEAPON_TYPE = ['simple', 'martial'];

    /**
     * @Assert\Choice(Weapon::WEAPON_TYPE)
     * @ORM\Column(type="string")
     */
    public string $weaponType;

    /**
     * @Assert\Choice(Weapon::DAMAGE_DICE)
     * @ORM\Column(type="integer")
     */
    public int $damageDiceType;

    /**
     * @ORM\Column(type="integer")
     */
    public int $damageDiceNumber;

    /**
     * @Assert\Choice(Weapon::DAMAGE_TYPE)
     * @ORM\Column(type="string")
     */
    public string $damageType;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $ammuntion = false;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $finesse = false;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $heavy = false;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $light = false;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $loading = false;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $reach = false;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $twoHanded = false;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $thrown = false;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    public ?int $shortRange;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    public ?int $longRange;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $versatile = false;

    /**
     * @Assert\Choice(Weapon::DAMAGE_DICE)
     * @ORM\Column(type="integer", nullable=true)
     */
    public ?int $versatileDamageDice;

    /**
     * @ORM\Column(type="boolean")
     * @ORM\Column(type="integer", nullable=true)
     */
    public ?int $versatileDamageDiceNumber;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $special = false;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $specialText;
}
