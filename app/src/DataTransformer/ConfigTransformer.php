<?php

namespace App\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Yaml\Parser;

class ConfigTransformer
{
    private const APP_ROOT = __DIR__ . '/../../';

    private ArmourFactory $armourFactory;
    private ItemFactory $itemfactory;
    private Parser $yamlParser;
    private WeaponFactory $weaponFactory;

    public function __construct(
        Parser $yamlParser,
        ItemFactory $itemfactory,
        ArmourFactory $armourFactory,
        WeaponFactory $weaponFactory
    ) {
        $this->armourFactory = $armourFactory;
        $this->itemfactory = $itemfactory;
        $this->weaponFactory = $weaponFactory;
        $this->yamlParser = $yamlParser;
    }

    public function listItems(string $fileLocation): Collection
    {
        $list = new ArrayCollection();
        foreach ($this->loadItems($fileLocation) as $name => $config) {
            $config['name'] = $name;

            switch ($config['itemType']) {
                case 'armour':
                    $list->add($this->armourFactory->build($config));
                    break;
                case 'weapon':
                    $list->add($this->weaponFactory->build($config));
                    break;
                default:
                    $list->add($this->itemFactory->build($config));
                    break;
            }
        }

        return $list;
    }

    private function loadItems(string $fileLocation): array
    {
        try {
            return $this->yamlParser->parseFile(self::APP_ROOT . ltrim($fileLocation, '/'));
        } catch (Throwable $t) {
            // do something
        }

        return [];
    }
}
