<?php

namespace App\Repository;

use App\Entity\Pensionnaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pensionnaires>
 *
 * @method Pensionnaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pensionnaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pensionnaires[]    findAll()
 * @method Pensionnaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PensionnairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pensionnaires::class);
    }

    // Méthode pour récupérer tous les pensionnaires avec leurs informations associées
    public function findAllWithInformations(): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.informationsPensionnaires', 'ip')
            ->addSelect('ip') // Sélectionner les informations de pensionnaire
            ->getQuery()
            ->getResult();
    }

    public function findIds(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id')
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Pensionnaires[] Returns an array of Pensionnaires objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Pensionnaires
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}