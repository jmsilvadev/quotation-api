<?php

namespace App\Repository;

use App\Entity\Quote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BasePremium|null find($id, $lockMode = null, $lockVersion = null)
 * @method BasePremium|null findOneBy(array $criteria, array $orderBy = null)
 * @method BasePremium[]    findAll()
 * @method BasePremium[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuoteRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quote::class);
    }
}
