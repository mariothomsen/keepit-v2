<?php

namespace App\Repository;

use App\Entity\Keepit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Keepit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Keepit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Keepit[]    findAll()
 * @method Keepit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeepitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Keepit::class);
    }

    public function save(Keepit $keepit): Keepit  {
        $this->_em->persist($keepit);
        $this->_em->flush();
        return $keepit;
    }
}
