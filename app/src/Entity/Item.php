<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"item"="Item", "armour"="Armour", "weapon"="Weapon"})
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */
class Item
{
    public const ITEM_TYPE = ['item', 'armour', 'weapon'];
    public const ITEM_LEVEL = ['normal', 'superior', 'masterwork'];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @Assert\Choice(Item::ITEM_TYPE)
     * @ORM\Column(type="string")
     */
    public string $itemType;

    /**
     * @Assert\Choice(Item::ITEM_LEVEL)
     * @ORM\Column(type="string")
     */
    public string $itemLevel = 'normal';

    /**
     * @ORM\Column(type="string", unique=true)
     */
    public string $name;

    /**
     * @ORM\Column(type="float")
     */
    public float $cost;

    /**
     * @ORM\Column(type="integer")
     */
    public int $weight;

    public function getId()
    {
        return $this->id;
    }
}
