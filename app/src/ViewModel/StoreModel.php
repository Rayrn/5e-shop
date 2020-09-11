<?php

namespace App\ViewModel;

use ArrayIterator;
use App\Helper\JsonStringable;
use Doctrine\Common\Collections\ArrayCollection;
use IteratorAggregate;

class StoreModel extends JsonStringable
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

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->shop->toArray());
    }

    /**
     * Overwrite as collections require some TLC to output correctly
     */
    public function asArray(): array
    {
        $store['id'] = $this->id;
        $store['name'] = $this->name;

        $store['shop'] = [];
        foreach ($this->listItems() as $item) {
            $store['shop'][] = $item->asArray();
        }

        return $store;
    }
}
