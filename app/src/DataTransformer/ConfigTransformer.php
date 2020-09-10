<?php

namespace App\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Yaml\Parser;

class ConfigTransformer
{
    private const APP_ROOT = __DIR__ . '/../../';

    private ItemFactoryInterface $itemFactory;

    public function __construct(Parser $yamlParser, ItemFactoryInterface $itemFactory)
    {
        $this->itemFactory = $itemFactory;
    }

    public function listItems(string $fileLocation): Collection
    {
        $list = new ArrayCollection();

        foreach ($this->loadItems($fileLocation) as $config) {
            $list->add($this->itemFactory->build($config));
        }

        return $list;
    }

    private function loadItems(string $fileLocation): array
    {
        try {
            $data = $this->yamlParser->parseFile(self::APP_ROOT . ltrim($fileLocation, '/'));

            foreach ($data as $key => $config) {
                $config['name'] = $key;
            }

            return $data;
        } catch (Throwable $t) {
            // do something
        }

        return [];
    }
}
