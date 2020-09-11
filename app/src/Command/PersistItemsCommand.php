<?php

namespace App\Command;

use App\DataTransformer\ConfigTransformer;
use App\Entity\Store;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PersistItemsCommand extends Command
{
    protected static $defaultName = 'app:persist-items';

    private ConfigTransformer $configTransformer;
    private EntityManagerInterface $entityManager;
    private ItemRepository $itemRepository;

    public function __construct(
        ConfigTransformer $configTransformer,
        ItemRepository $itemRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->configTransformer = $configTransformer;
        $this->itemRepository = $itemRepository;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Import items from yaml file.')
            ->setHelp('This command allows you to import items set up in assets/items-config.yaml into the database.');
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $items = $this->configTransformer->getItems('assets/item-config.yaml');

        foreach ($items as $configItem) {
            $dbItem = $this->itemRepository->findOneBy(['name' => $configItem->name]);

            if ($dbItem) {
                foreach ($configItem as $key => $value) {
                    $dbItem->$key = $value;
                }

                $this->entityManager->persist($dbItem);
                $this->entityManager->flush();
                continue;
            }

            $this->entityManager->persist($configItem);
            $this->entityManager->flush();
        }
        
        return Command::SUCCESS;
    }
}
