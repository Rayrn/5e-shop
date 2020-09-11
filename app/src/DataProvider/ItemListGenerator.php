<?php

namespace App\DataProvider;

use App\DataTransformer\ItemFactoryInterface;
use App\Entity\Item;
use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ItemListGenerator
{
    private ItemFactoryInterface $itemFactory;
    private ItemRepository $itemRepository;

    public function __construct(ItemRepository $itemRepository, ItemFactoryInterface $itemFactory)
    {
        $this->itemRepository = $itemRepository;
        $this->itemFactory = $itemFactory;
    }

    public function generate(int $storeId): Collection
    {
        srand($storeId);

        $superiorThreshold = rand(80, 90); // 1:5 to 1:10
        $masterworkThreshold = rand(95, 99); // 1:20 to 1:100

        $maxId = $this->itemRepository->getMaxId();

        $items = new ArrayCollection();
        for ($i = 0; $i < rand(3, 40); $i++) {
            $item = $this->itemRepository->find(rand(1, $maxId));

            if ($item) {
                $items->add(
                    $this->upgradeItem($item, $superiorThreshold, $masterworkThreshold)
                );
            }
        }

        return $items;
    }

    private function upgradeItem(Item $item, int $superiorThreshold, int $masterworkThreshold): Item
    {
        $dice = rand(1, 100);
        if ($dice > $superiorThreshold) {
            $item = $this->itemFactory->upgrade($item);
        }

        $dice = rand(1, 100);
        if ($dice > $masterworkThreshold) {
            $item = $this->itemFactory->upgrade($item);
        }

        return $item;
    }
}
