<?php

namespace App\ViewModel;

use ArrayIterator;
use Doctrine\Common\Collections\ArrayCollection;
use IteratorAggregate;
use JsonSerializable;

class StoreModel implements JsonSerializable
{
    public string $id;
    public string $name;
    private ArrayCollection $shop;

    public function __construct()
    {
        $this->shop = new ArrayCollection();
    }

    public function listItems(): array
    {
        return $this->shop->getValues();
    }

    public function addItem(ItemModel $item): void
    {
        $this->shop->add($item);
    }

    public function asArray()
    {
        $store = [
            'id' => $this->id,
            'name' => $this->name
        ];

        foreach ($this->listItems() as $item) {
            $store['shop'][] = $item->asArray();
        }

        return $store;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->asArray());
    }

    public function jsonSerialize()
    {
        return json_encode($this->asArray());
    }
}
