<?php

namespace App\Repository;

use App\Entity\DemandeAdmin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemandeAdmin>
 *
 * @method DemandeAdmin|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeAdmin|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeAdmin[]    findAll()
 * @method DemandeAdmin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeAdminRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeAdmin::class);
    }

    public function save(DemandeAdmin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DemandeAdmin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DemandeAdmin[] Returns an array of DemandeAdmin objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DemandeAdmin
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
