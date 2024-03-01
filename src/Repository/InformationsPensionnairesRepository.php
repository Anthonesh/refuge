<?php

namespace App\Repository;

use App\Entity\InformationsPensionnaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InformationsPensionnaires>
 *
 * @method InformationsPensionnaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method InformationsPensionnaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method InformationsPensionnaires[]    findAll()
 * @method InformationsPensionnaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InformationsPensionnairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InformationsPensionnaires::class);
    }

//    /**
//     * @return InformationsPensionnaires[] Returns an array of InformationsPensionnaires objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InformationsPensionnaires
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
