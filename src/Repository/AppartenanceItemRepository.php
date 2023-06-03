<?php

namespace App\Repository;

use App\Entity\AppartenanceItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppartenanceItem>
 *
 * @method AppartenanceItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppartenanceItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppartenanceItem[]    findAll()
 * @method AppartenanceItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppartenanceItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppartenanceItem::class);
    }

    public function save(AppartenanceItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AppartenanceItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AppartenanceItem[] Returns an array of AppartenanceItem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AppartenanceItem
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
