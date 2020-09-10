<?php

namespace App\Repository;

use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function getMaxId(): int
    {
        $id = $this->createQueryBuilder('u')
            ->select('MAX(e.id)')
            ->from('App:Item', 'e')
            ->getQuery()
            ->getSingleResult();

        return reset($id);
    }
}
