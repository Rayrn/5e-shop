<?php

namespace App\DataTransformer;

use App\Entity\Item;

class ItemFactoryDelegate implements ItemFactoryInterface
{
    /**
     * @var ItemFactoryInterface[]
     */
    private array $factories;

    public function __construct(ItemFactoryInterface ...$factories)
    {
        $this->factories = $factories;
    }

    public function build(array $config): ?Item
    {
        $factory = $this->getFactory($config['itemType'] ?? '');

        if (!$factory) {
            return null;
        }

        return $factory->build($config);
    }

    public function upgrade(Item $item): Item
    {
        $factory = $this->getFactory($item->itemType);

        if (!$factory) {
            return $item;
        }

        return $factory->upgrade($item);
    }

    public function supports(string $itemType): bool
    {
        return (bool) $this->getFactory($itemType);
    }

    private function getFactory(string $itemType): ?ItemFactoryInterface
    {
        $factories = array_filter($this->factories, function ($factory) use ($itemType) {
            return $factory->supports($itemType);
        });


        return $factories ? reset($factories) : null;
    }
}
