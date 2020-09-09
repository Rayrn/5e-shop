<?php

namespace App\ViewModel;

use ArrayIterator;
use Doctrine\Common\Collections\ArrayCollection;
use IteratorAggregate;
use JsonSerializable;

class StoreModel implements JsonSerializable
{
    public string $name;
    private ArrayCollection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function listItems(): array
    {
        return $this->items->getValues();
    }

    public function addItem(ItemModel $item): void
    {
        $this->items->add($item);
    }

    public function asArray()
    {
        $store = [
            'name' => $this->name
        ];

        foreach ($this->listItems() as $item) {
            $store['items'][] = $item->asArray();
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
