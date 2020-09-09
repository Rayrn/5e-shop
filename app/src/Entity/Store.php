<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Store
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToMany(targetEntity="Item")
     * @ORM\JoinTable(name="store_items",
     *     joinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="shop_id", referencedColumnName="id")}
     * )
     */
    private ArrayCollection $items;

    /**
     * @ORM\Column(type="string")
     */
    public string $name;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function listItems(): array
    {
        return $this->items->getValues();
    }

    public function addItem(Item $item): void
    {
        $this->items->add($item);
    }

    public function removeItem(Item $item): void
    {
        foreach ($this->listItems() as $key => $value) {
            if ($value == $item) {
                $this->items->remove($key);
                break;
            }
        }
    }
}
