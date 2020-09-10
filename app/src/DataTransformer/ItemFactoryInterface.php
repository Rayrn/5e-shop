<?php

namespace App\DataTransformer;

use App\Entity\Item;

interface ItemFactoryInterface
{
    public function build(array $config): ?Item;
    public function upgrade(Item $item): Item;
    public function supports(string $itemType): bool;
}
